<?php

namespace App\Http\Resources;

use App\Http\Resources\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'slug' => $this->slug,
            'email' => $this->email,
            'role' => $this->role_id,
            'role_name' => ucwords($this->getRoleNames()->first()),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'profile' => new ProfileResource($this->profile),
        ];
    }
}
