<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validator($factory)
    {
    return $factory->make(
        $this->sanitize(), $this->container->call([$this, 'rules']), $this->messages()
    );
    }

    public function sanitize()
    {
        $data = [];

        foreach ($this->all() as $key => $value) {
            $data[$key] = json_decode($value, true);
        }

        $this->merge($data);

        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $location_id = $this->location_id;
        $block = $this->block;
        $lot = $this->lot;
        $phase = $this->phase;
        
        return [
            'location_id' => 'required',
            'block' => [
                'required',
                Rule::unique('properties')->where(function ($query) use($location_id, $block, $lot) {
                    return $query
                        ->where('location_id', $location_id)
                        ->where('block', $block)
                        ->where('lot', $lot);
                }),
            ],
            'lot' => [
                'required',
                Rule::unique('properties')->where(function ($query) use($location_id, $block, $lot) {
                    return $query
                        ->where('location_id', $location_id)
                        ->where('block', $block)
                        ->where('lot', $lot);
                }),
            ],
            'phase' => [
                Rule::unique('properties')->where(function ($query) use($location_id, $block, $lot, $phase) {
                    return $query
                        ->where('location_id', $location_id)
                        ->where('block', $block)
                        ->where('lot', $lot)
                        ->where('phase', $phase);
                }),
            ],
            'lot_size' => 'required',
            
            'contract_price' => 'required',
            'default_monthly_amortization' => 'required',
            'term' => 'required',
            'status' => 'required',
            'photo' => 'max:1000',
            // 'description' => 'required',
        ];
    }

    public function save()
    {
        $property = Property::create($this->all());
        
        if ($this->photo) {
            $file = $this->photo;
            $filename = $file->getClientOriginalName();
            $file->storeAs('properties/' . $property->id, $filename, 's3');

            $property->update([
                'photo' => $filename
            ]);
        }

        return $property;
    }
}
