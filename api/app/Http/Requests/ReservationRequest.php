<?php

namespace App\Http\Requests;

use Str;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use App\Models\Attorney;
use App\Models\Document;
use App\Models\Property;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    protected $choose_property;
    protected $location;
    protected $personal_information;
    protected $employment_status;
    protected $spouse_information;
    protected $co_borrower_information;
    protected $attorney_information;

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
            // 'choose_property.monthly_amortization' => 'required',
        ];
    }

    public function save()
    {
        $documents = Document::all();

        $this->choose_property = Collect(json_decode($this->chooseProperty))->toArray();
        $this->personal_information = Collect(json_decode($this->personalInformation))->toArray();
        $this->employment_status = Collect(json_decode($this->employmentStatus))->toArray();
        $this->spouse_information = Collect(json_decode($this->spouseInformation))->toArray();
        $this->co_borrower_information = Collect(json_decode($this->coBorrowerInformation))->toArray();
        $this->attorney_information = Collect(json_decode($this->attorneyInformation))->toArray();
        $this->location = Collect($this->choose_property['selectedLocation'])->toArray();

        $property = Property::where('location_id', $this->location['location_id'])
                        ->where('block', $this->location['block'])
                        ->where('lot', $this->location['lot'])
                        ->where('phase', $this->location['phase'])
                        ->first();

        $buyer = $this->createBuyer();   

        $co_borrower = $this->createCoBorrower($buyer);

        $attorney = $this->createAttorney();

        if ($property) {
            $property_attr = $this->choose_property;
            $property_attr['property_id'] = $property->id;
            $property_attr['co_borrower_id'] = $co_borrower->id;
            $property_attr['attorney_id'] = $attorney->id;

            $buyer->reservations()->create($property_attr);
        }
        
        foreach ($documents as $document) {
            if ($this->hasFile($document->title)) {
                $file_path = Storage::disk('local')->put($document->title. '/' . $buyer->id, $this->file($document->title));
            }
        }
    }

    protected function createBuyer()
    {
        $role = Role::where('name', 'buyer')->first();
        $name = $this->personal_information['first_name'] . ' ' . $this->personal_information['last_name'];

        $buyer = User::create([
            "role_id" => $role->id,
            "name" => $name,
            "email" => $this->personal_information['email'],
            'password' => Hash::make(Str::random(10))
        ]);
        
        $this->createBuyerProfile($buyer);

        $buyer->employmentStatus()->create($this->employment_status);

        return $buyer;
    }

    protected function createBuyerProfile($buyer)
    {
        $profile_info = [];
        $profile_info['user_id'] = $buyer->id;

        $profile_info = array_merge($profile_info, $this->personal_information);
        $profile_info = array_merge($profile_info, $this->spouse_information);

        Profile::create($profile_info);
    }

    protected function createCoBorrower($buyer)
    {
        if (isset($this->co_borrower_information)) {
            return $buyer->coBorrowers()->create($this->co_borrower_information);
        }

        return false;
    }

    protected function createAttorney()
    {
        if (isset($this->attorney_information)) {
            return Attorney::create($this->attorney_information);
        }

        return false;
    }
    
}
