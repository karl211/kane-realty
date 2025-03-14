<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    private static $blocks;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $file = null;
        $active_color = null;
        $file_path = 'properties/' . $this->id . '/' . $this->photo;

        if ($this->photo) {
            $file = Storage::disk('s3')->temporaryUrl($file_path, now()->addMinutes(2));
        } else {
            $file = url('/images/default-property.gif');
        }

        switch ($this->status) {
            case 'Available':
                $active_color = 'green';
                break;
            case 'Reserved':
                $active_color = 'orange';
                break;
            case 'Cancelled':
                $active_color = 'red';
                break;
            case 'For Assume':
                $active_color = 'blue';
                break;
        }

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
            'photo' => $file,
            'contract_price' => $this->contract_price,
            'default_monthly_amortization' => $this->default_monthly_amortization,
            'term' => $this->term,
            'location' => $this->location,
            'reservation_owner' => (count($this->reservations)) ? $this->reservations->first()->buyer->profile->full_name : '',
            'status' => $this->status,
            'blocks' => self::$blocks,
            'edit_status' => false,
            'active_color' => $active_color,
        ];
    }

    //I made custom function that returns collection type
    public static function customCollection($resource, $blocks): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        //you can add as many params as you want.
        self::$blocks = $blocks;
        return parent::collection($resource);
    }
}
