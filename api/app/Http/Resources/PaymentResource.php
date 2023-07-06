<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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
        $file_url = null;
        $file_path = 'payments/' . $this->buyer_id . '/' . $this->mode_of_payment . '/' . $this->image;

        if ($this->image) {
            $file_url = Storage::disk('s3')->temporaryUrl($file_path, now()->addMinutes(15));
        }

        return [
            'payment_id' => $this->id,
            'reservation_id' => $this->reservation_id,
            'ar_number' => $this->ar_number,
            'or_number' => $this->or_number,
            'amount' => $this->amount,
            'type_of_payment' => $this->type_of_payment,
            'mode_of_payment' => $this->mode_of_payment,
            'paid_at' => Carbon::parse($this->paid_at)->format('F d, Y'),
            'original_paid_at' => $this->paid_at,
            'name' => $this->reservation->buyer->profile->full_name,
            'property' => $this->reservation->property->full_property,
            'contract_price' => $this->reservation->contract_price,
            'balance' => $this->reservation->contract_price,
            'buyer' => $this->buyer,
            'file_name' => $this->image,
            'file_url' => $file_url,
        ];
    }
}
