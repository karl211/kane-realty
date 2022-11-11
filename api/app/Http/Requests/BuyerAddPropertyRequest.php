<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;

class BuyerAddPropertyRequest extends FormRequest
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
            'chooseProperty.selectedLocation.location_id' => 'required',
            'chooseProperty.selectedLocation.block' => 'required',
            'chooseProperty.selectedLocation.lot' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'chooseProperty.selectedLocation.location_id.required' => 'This field is required.',
            'chooseProperty.selectedLocation.block.required' => 'This field is required.',
            'chooseProperty.selectedLocation.lot.required' => 'This field is required.',
            'chooseProperty.selectedLocation.phase.required' => 'This field is required.',
            'chooseProperty.contract_price.required' => 'This field is required.',
            'chooseProperty.monthly_amortization.required' => 'This field is required.',
            'chooseProperty.term.required' => 'This field is required.'
        ];
    }

    public function save($buyer)
    {
        $choose_property = $this->chooseProperty;
        
        $property = Property::withoutGlobalScope('default_branch')
                        ->where('location_id', $choose_property['selectedLocation']['location_id'])
                        ->where('block', $choose_property['selectedLocation']['block'])
                        ->where('lot', $choose_property['selectedLocation']['lot'])
                        ->first();

        if ($property) {
            $recent_reservation = $buyer->reservations()->latest()->first();

            $reservation = $buyer->reservations()->create([
                'property_id' => $property->id,
                'co_borrower_id' => $recent_reservation->co_borrower_id,
                'attorney_id' => $recent_reservation->attorney_id,
                'contract_price' => $property->contract_price,
                'monthly_amortization' => $property->default_monthly_amortization,
                'term' => $property->term,
                'transaction_at' => $choose_property['transaction_at'],
                'status' => 'On Going'
            ]);

            $property->update([
                'status' => 'Reserved'
            ]);

            return $reservation;
        } else {
            abort(402, 'Property is not available');
        }
    }

}
