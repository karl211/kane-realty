<?php

namespace App\Http\Resources;

use App\Http\Resources\SpouseResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\CoborrowerResource;
use App\Http\Resources\ReservationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyerResource extends JsonResource
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
            'buyer_id' => $this->id,
            'slug' => $this->slug,
            'email' => $this->email,
            'profile' => new ProfileResource($this->profile),
            'documents' => DocumentResource::collection($this->documents),
            'spouse' => SpouseResource::collection($this->spouses)->last(),
            'co_borrower' => CoborrowerResource::collection($this->spouses)->last(),
            'reservations' => ReservationResource::collection($this->reservations),
        ];
    }
}
