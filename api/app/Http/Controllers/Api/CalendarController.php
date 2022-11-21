<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CalendarResource;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $reservations = Reservation::with('buyer.profile', 'property')
            ->when(request()->search, function ($query) {
                $query->search(request()->search);
            })
            ->where('status', 'On Going')
            ->paginate(999999)
            ->through(function($reservation){
                
                if (count($this->filterData($reservation)['past_dues'])) {
                    return $reservation['past_dues'] = $this->filterData($reservation)['past_dues'];
                }

                return false;
            })
            ->sortBy('property.lot')
            ->sortBy('property.block');
            
        return $reservations;
        // return CalendarResource::collection($reservations);
        // $search = null;
        // if (isset(request('search'))) {
        //     $search = request('search')['search'];
        // }
        
        // $reservations = Reservation::with('buyer.profile', 'property', 'payments')
        //     ->with(['payments' => function($query) {
        //         $query->orderBy('paid_at', 'asc');
        //     }])
        //     ->when(request()->search, function ($query) {
        //         $query->search(request()->search);
        //     })
        //     ->where('status', 'On Going')
        //     ->paginate(999999)
        //     ->through(function($reservation){
        //         if (request()->type == 'Upcoming Invoice') {
        //             $reservation['upcoming_invoices'] = $this->filterData($reservation)['upcoming_invoices'];
        //         }
        //         else if (request()->type == 'Past Due') {
        //             $reservation['past_dues'] = $this->filterData($reservation)['past_dues'];
        //         }
        //         else if (request()->type == 'Paid') {
        //             $reservation['paids'] = $this->filterData($reservation)['paids'];
        //         }
                
        //         return $reservation;
        //     })
        //     ->sortBy('property.lot')
        //     ->sortBy('property.block');
            
        // return InvoiceReserouce::collection($reservations);
    }

    protected function filterData($reservation)
    {
        $due_dates = [];
        $past_dues = [];
        $upcoming_invoices = [];
        $paids = [];
        $now = Carbon::now();

        $start = Carbon::parse($reservation->transaction_at)->addMonth();
        $end = Carbon::parse($reservation->transaction_at)->addMonths($reservation->term);
        $payments = $reservation->payments;
        
        while ($start->lte($end)) {
            $due_dates[] = $start->format('Y-m-d');
            $start->addMonth();
        }

        foreach ($due_dates as $due_date) {
            $is_paid = false;
            foreach ($payments as $payment) {
                if (Carbon::parse($payment->paid_at)->year == Carbon::parse($due_date)->year && Carbon::parse($payment->paid_at)->month == Carbon::parse($due_date)->month) {
                    $is_paid = true;
                }
            }

            if (!$is_paid) {
                $filter_end = Carbon::now();
                
                if ($filter_end->gte($due_date)) {
                    $photo = null;
                    $photo_path = 'buyers/' . $reservation->buyer->id . '/' . $reservation->buyer->profile->photo;

                    if ($reservation->buyer->profile->photo) {
                        $photo = Storage::disk('s3')->temporaryUrl($photo_path, now()->addMinutes(2));
                    } else {
                        $photo = url('/images/default-user.png');
                    }

                    $past_dues[] = [
                        'due_date' => $due_date,
                        'monthly_amortization' => $reservation->monthly_amortization,
                        'status' => 'Past due',
                        'name' => $reservation->buyer->profile->full_name,
                        'photo' => $photo,
                        'property' => 'Block ' . $reservation->property->block . ' - ' . 'Lot ' . $reservation->property->lot,
                    ];
                }
            }
        }

        return [
            'past_dues' => $past_dues,
        ];
    }
}
