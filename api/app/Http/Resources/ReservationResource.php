<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\UserResource;
use App\Http\Resources\AttorneyResource;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) 
    {
        $count_amortization = 0;
        $count_amortization_advance = 1;
        foreach ($this->payments as $payment) {
            if ($payment->type_of_payment == 'Monthly Amortization') {
                $count_amortization += 1;
                $count_amortization_advance += 1;
            }
        }

        return [
            'id' => $this->id,
            'buyer_id' => $this->buyer->id,
            'name' => $this->buyer->profile->full_name,
            'slug' => $this->buyer->slug,
            'contract_price' => $this->contract_price,
            'balance' => $this->contract_price,
            'term' => $this->term,
            'date_of_transaction' => Carbon::parse($this->transaction_at)->format('F d, Y'),
            'status' => $this->status,
            'amortization_count_advance' => $this->ordinal($count_amortization_advance),
            'amortization_count' => $this->ordinal($count_amortization),
            'sales_manager' => new UserResource($this->sales_manager),
            'sales_agent' => new UserResource($this->sales_agent),
            'attorney' => new AttorneyResource($this->attorney),
            'property' => new PropertyResource($this->property),
            'payments' => PaymentResource::collection($this->payments),
        ];
    }

    protected function ordinal($number) {
        if ($number) {
            $ends = array('th','st','nd','rd','th','th','th','th','th','th');
            if ((($number % 100) >= 11) && (($number%100) <= 13))
                return $number. 'th';
            else
                return $number. $ends[$number % 10];
        }

        return $number;
        
    }
}
