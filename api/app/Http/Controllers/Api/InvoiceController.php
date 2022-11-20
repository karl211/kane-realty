<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceReserouce;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        // $search = null;
        // if (isset(request('search'))) {
        //     $search = request('search')['search'];
        // }
        
        $reservations = Reservation::with('buyer.profile', 'property', 'payments')
            ->with(['payments' => function($query) {
                $query->orderBy('paid_at', 'asc');
            }])
            ->when(request()->search, function ($query) {
                $query->search(request()->search);
            })
            ->where('status', 'On Going')
            ->paginate(999999)
            ->through(function($reservation){
                if (request()->type == 'Upcoming Invoice') {
                    $reservation['upcoming_invoices'] = $this->filterData($reservation)['upcoming_invoices'];
                }
                else if (request()->type == 'Past Due') {
                    $reservation['past_dues'] = $this->filterData($reservation)['past_dues'];
                }
                else if (request()->type == 'Paid') {
                    $reservation['paids'] = $this->filterData($reservation)['paids'];
                }
                
                return $reservation;
            })
            ->sortBy('property.lot')
            ->sortBy('property.block');
            
        return InvoiceReserouce::collection($reservations);
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
                    $paids[] = [
                        'paid_at' => $due_date,
                        'amount' => $payment->amount,
                        'status' => 'Paid',
                    ];
                }
            }

            if (!$is_paid) {
                $filter_end = Carbon::now();
                
                if (request()->filter_month == 'All') {
                    if ($filter_end->gte($due_date)) {
                        $past_dues[] = [
                            'due_date' => $due_date,
                            'monthly_amortization' => $reservation->monthly_amortization,
                            'status' => 'Past due',
                        ];
                    }
                } else {
                    $filter_end = Carbon::now()->endOfMonth();

                    switch (request()->filter_month) {
                        case 'This month':
                            $filter_start = Carbon::now()->startOfMonth();
                            break;
                        case 'Last 3 months':
                            $filter_start = Carbon::now()->subMonths(3)->startOfMonth();
                            break;
                        case 'Last 6 months':
                            $filter_start = Carbon::now()->subMonths(6)->startOfMonth();
                            break;
                        case 'Last 12 months':
                            $filter_start = Carbon::now()->subMonths(12)->startOfMonth();
                            break;
                    }

                    if ($filter_start->lte($due_date) && $filter_end->gte($due_date)) {
                        $past_dues[] = [
                            'due_date' => $due_date,
                            'monthly_amortization' => $reservation->monthly_amortization,
                            'status' => 'Past due',
                        ];
                    }

                }

                
            }
            if ($now->lte($due_date)) {
                $upcoming_invoices[] = [
                    'due_date' => $due_date,
                    'monthly_amortization' => $reservation->monthly_amortization,
                    'status' => 'Next invoice',
                ];
            }
        }

        return [
            'paids' => $paids,
            'past_dues' => $past_dues,
            'upcoming_invoices' => $upcoming_invoices,
        ];
    }
}
