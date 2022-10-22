<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'suffix' => $this->suffix,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'tin' => $this->tin,
            'date_of_birth' => $this->date_of_birth,
            'civil_status' => $this->civil_status,
            'religion' => $this->religion,
            'contact_number' => $this->contact_number,
            'zip_code' => $this->zip_code,
            'address' => $this->address,
            'photo' => $this->photo,
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
        ];
    }
}
