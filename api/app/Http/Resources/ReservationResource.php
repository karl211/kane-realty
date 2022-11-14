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
        return [
            'id' => $this->id,
            'buyer_id' => $this->buyer->id,
            'name' => $this->buyer->profile->full_name,
            'slug' => $this->buyer->slug,
            'contract_price' => $this->contract_price,
            'balance' => $this->contract_price,
            'term' => $this->term,
            'date_of_transaction' => Carbon::parse($this->transaction_at)->format('M d, Y'),
            'status' => $this->status,
            'sales_manager' => new UserResource($this->sales_manager),
            'sales_agent' => new UserResource($this->sales_agent),
            'attorney' => new AttorneyResource($this->attorney),
            'property' => new PropertyResource($this->property),
            'payments' => PaymentResource::collection($this->payments),
        ];
    }
}
