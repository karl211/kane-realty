<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceReserouce extends JsonResource
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
            'monthly_amortization' => $this->monthly_amortization,
            'term' => $this->term,
            'date_of_transaction' => Carbon::parse($this->transaction_at)->format('M d, Y'),
            'status' => $this->status,
            'upcoming_invoices' => $this->upcoming_invoices,
            'past_dues' => $this->past_dues,
            'paids' => $this->paids,
            'property' => 'Block ' . $this->property->block . ' - ' . 'Lot ' . $this->property->lot,
            'location' => $this->property->location->location,
            'sales_manager' => new UserResource($this->sales_manager),
            'sales_agent' => new UserResource($this->sales_agent),
            'attorney' => new AttorneyResource($this->attorney),
            'payments' => PaymentResource::collection($this->payments)
        ];
    }
}
