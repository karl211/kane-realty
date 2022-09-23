<?php

namespace App\Http\Resources;

use App\Http\Resources\PropertyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'description' => $this->description,
            'location' => $this->location,
            'photo' => $this->photo,
            'properties' => PropertyResource::collection($this->properties)
        ];
    }
}
