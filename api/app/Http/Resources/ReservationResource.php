<?php

namespace App\Http\Resources;

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
        return [
            'buyer_id' => $this->buyer->id,
            'name' => $this->buyer->name,
            'property' => $this->property->location->location,
            'contract_price' => $this->contract_price,
            'balance' => $this->contract_price,
            'term' => $this->term,
            'date_of_transaction' => $this->transaction_at,
            'status' => 'Ongoing',
        ];
    }
}
