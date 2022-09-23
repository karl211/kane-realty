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
            'description' => $this->description,
            'full_property' => $this->full_property,
            'status' => $this->status,
            'photo' => $this->photo,
        ];
    }
}
