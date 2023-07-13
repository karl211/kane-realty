<?php

namespace App\Http\Requests;

use App\Models\Location;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
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
        $location = Location::where('location', $this->location)->first();
        $edit_lot_rule = [
            'required'
        ];

        if ($this->is_edit_block_lot) {
            $edit_lot_rule = [
                'required',
                Rule::unique('properties')->where(function ($query) use ($location) {
                    return $query->where('location_id', $location->id)->where('block', $this->block)->where('deleted_at', NULL);
                }),
            ];
        }
        
        return [
            'lot' => $edit_lot_rule,
            'block' => 'required',
            'term' => 'required',
            'lot_size' => 'required',
            'default_monthly_amortization' => 'required',
            'contract_price' => 'required',
            'status' => 'required',
        ];
    }

    public function save($property)
    {
        return $property->update([
            'lot' => $this->lot,
            'block' => $this->block,
            'term' => $this->term,
            'phase' => $this->phase,
            'lot_size' => $this->lot_size,
            'default_monthly_amortization' => $this->default_monthly_amortization,
            'contract_price' => $this->contract_price
        ]);
    }
}
