<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReservationDueNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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
    }
}
