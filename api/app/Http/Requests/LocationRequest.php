<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'branch_id' => 'required',
            'location' => 'required',
            'description' => 'required',
            'type' => 'required',
        ];
    }

    public function save()
    {
        if (!$this->map) {
            $branch = Branch::find($this->branch_id);
            $this['map'] = 'https://maps.google.com/maps?q=' . $this->location  . '&z=14&ie=UTF8&iwloc=&output=embed';
        }
        
        return Location::create($this->all());
    }
}
