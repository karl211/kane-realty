<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ar_number' => $this->ar_number,
            'amount_paid' => $this->amount,
            'type_of_payment' => $this->type_of_payment,
            'mode_of_payment' => $this->mode_of_payment,
            'paid_at' => Carbon::parse($this->paid_at)->format('M d, Y'),
            'name' => $this->reservation->buyer->profile->full_name,
            'property' => $this->reservation->property->full_property,
            'contract_price' => $this->reservation->contract_price,
            'balance' => $this->reservation->contract_price,
        ];
    }
}
