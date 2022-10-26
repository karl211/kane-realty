<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
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
            'block' => $this->block,
            'lot' => $this->lot,
            'phase' => $this->phase,
            'floor_area' => $this->floor_area,
            'model' => $this->model,
            'lot_size' => $this->lot_size,
            'description' => $this->description,
            'full_property' => $this->full_property,
            'photo' => $this->photo,
            'contract_price' => $this->contract_price,
            'default_monthly_amortization' => $this->default_monthly_amortization,
            'term' => $this->term,
            'location' => $this->location,
            'status' => $this->status,
        ];
    }
}
