<?php

namespace App\Http\Requests;

use Str;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            //
        ];
    }

    public function save()
    {
        return $this->createBuyer();
    }

    protected function createBuyer()
    {
        $profile_info = [];

        $role = Role::where('name', 'buyer')->first();
        $name = $this->personalInformation['first_name'] . ' ' . $this->personalInformation['last_name'];

        $buyer = User::create([
            "role_id" => $role->id,
            "name" => $name,
            "email" => $this->personalInformation['email'],
            'password' => Hash::make(Str::random(10))
        ]);
        
        $profile_info['user_id'] = $buyer->id;
        $spouseInformation = array_map(function ($key, $item) {
            return 'spouse_' . $key;
        }, array_keys($this->spouseInformation), $this->spouseInformation);
        $profile_info = array_merge($profile_info, $this->personalInformation);
        $profile_info = array_merge($profile_info, $this->spouseInformation);

        Profile::create($profile_info);

        return $buyer;
    }
    
}
