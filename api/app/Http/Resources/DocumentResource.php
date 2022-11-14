<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
        $file_path = 'buyers/' . $this->pivot->buyer_id . '/' . $this->title . '/' . $this->pivot->file;

        if ($this->pivot->file) {
            $file_url = Storage::disk('s3')->temporaryUrl($file_path, now()->addMinutes(15));
        }

        return [
            'title' => $this->title,
            'desc' => $this->desc,
            'file_name' => $this->pivot->file,
            'file_url' => $file_url,
        ];
    }
}
