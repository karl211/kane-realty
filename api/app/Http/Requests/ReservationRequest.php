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
use Cviebrock\EloquentSluggable\Services\SlugService;

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

    public function validator($factory)
    {
        return $factory->make(
            $this->sanitize(), $this->container->call([$this, 'rules']), $this->messages()
        );
    }

    public function sanitize()
    {
        $this->merge([
            'chooseProperty' => json_decode($this->input('chooseProperty'), true),
            'personalInformation' => json_decode($this->input('personalInformation'), true),
            'spouseInformation' => json_decode($this->input('spouseInformation'), true),
            'coBorrowerInformation' => json_decode($this->input('coBorrowerInformation'), true),
            'attorneyInformation' => json_decode($this->input('attorneyInformation'), true),
            'employmentStatus' => json_decode($this->input('employmentStatus'), true),
            'documents' => json_decode($this->input('documents'), true),
            'branch_id' => json_decode($this->input('branch_id'), true)
        ]);
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->personalInformation) {
            $this->personal_information = Collect($this->personalInformation)->toArray();
        }
        if ($this->employmentStatus) {
            $this->employment_status = Collect($this->employmentStatus)->toArray();
        }
        
        $all_rules = [
            'chooseProperty.selectedLocation.location_id' => 'required',
            'chooseProperty.selectedLocation.block' => 'required',
            'chooseProperty.selectedLocation.lot' => 'required',

            'personalInformation.last_name' => 'required',
            'personalInformation.first_name' => 'required',
            'personalInformation.middle_name' => 'required',
            'personalInformation.email' => 'required',
            'personalInformation.date_of_birth' => 'required',
            'personalInformation.gender' => 'required',
            'personalInformation.civil_status' => 'required',
            'personalInformation.religion' => 'required',
            'personalInformation.address' => 'required',
            'personalInformation.zip_code' => 'required',
            'personalInformation.contact_number' => 'required',

            'coBorrowerInformation.last_name' => 'required',
            'coBorrowerInformation.first_name' => 'required',
            'coBorrowerInformation.middle_name' => 'required',
            'coBorrowerInformation.date_of_birth' => 'required',
            'coBorrowerInformation.gender' => 'required',
            'coBorrowerInformation.contact_number' => 'required',

            'employmentStatus.employment' => 'required',

            'valid_id' => 'required|max:1000',
        ];
        
        if (isset($this->personal_information['civil_status']) && ($this->personal_information['civil_status'] == 'Married')) {
            $all_rules = array_merge(self::spouseInfoRules(), $all_rules);
        }
        
        if (isset($this->employment_status['employment']) && ($this->employment_status['employment'] == 'OWF Sea Based' || $this->employment_status['employment'] == 'OWF Land Based')) {
            $all_rules = array_merge(self::attorneyInfoRules(), $all_rules);
        }

        return $all_rules;
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
            'chooseProperty.term.required' => 'This field is required.',

            'personalInformation.last_name.required' => 'This field is required.',
            'personalInformation.first_name.required' => 'This field is required.',
            'personalInformation.middle_name.required' => 'This field is required.',
            'personalInformation.email.required' => 'This field is required.',
            'personalInformation.date_of_birth.required' => 'This field is required.',
            'personalInformation.gender.required' => 'This field is required.',
            'personalInformation.civil_status.required' => 'This field is required.',
            'personalInformation.religion.required' => 'This field is required.',
            'personalInformation.address.required' => 'This field is required.',
            'personalInformation.zip_code.required' => 'This field is required.',
            'personalInformation.contact_number.required' => 'This field is required.',

            'spouseInformation.last_name.required' => 'This field is required.',
            'spouseInformation.first_name.required' => 'This field is required.',
            'spouseInformation.middle_name.required' => 'This field is required.',
            'spouseInformation.date_of_birth.required' => 'This field is required.',
            'spouseInformation.gender.required' => 'This field is required.',
            'spouseInformation.contact_number.required' => 'This field is required.',

            'coBorrowerInformation.last_name.required' => 'This field is required.',
            'coBorrowerInformation.first_name.required' => 'This field is required.',
            'coBorrowerInformation.middle_name.required' => 'This field is required.',
            'coBorrowerInformation.date_of_birth.required' => 'This field is required.',
            'coBorrowerInformation.gender.required' => 'This field is required.',
            'coBorrowerInformation.contact_number.required' => 'This field is required.',

            'attorneyInformation.last_name.required' => 'This field is required.',
            'attorneyInformation.first_name.required' => 'This field is required.',
            'attorneyInformation.middle_name.required' => 'This field is required.',
            'attorneyInformation.date_of_birth.required' => 'This field is required.',
            'attorneyInformation.gender.required' => 'This field is required.',
            'attorneyInformation.contact_number.required' => 'This field is required.',

            'employmentStatus.employment.required' => 'This field is required.',

            'valid_id.required' => 'This field is required.',
        ];
    }

    public static function spouseInfoRules() {
        return [
            'spouseInformation.last_name' => 'required',
            'spouseInformation.first_name' => 'required',
            'spouseInformation.middle_name' => 'required',
            'spouseInformation.date_of_birth' => 'required',
            'spouseInformation.gender' => 'required',
            'spouseInformation.contact_number' => 'required',
        ];
    }

    public static function attorneyInfoRules() {
        return [
            'attorneyInformation.last_name' => 'required',
            'attorneyInformation.first_name' => 'required',
            'attorneyInformation.middle_name' => 'required',
            'attorneyInformation.date_of_birth' => 'required',
            'attorneyInformation.gender' => 'required',
            'attorneyInformation.contact_number' => 'required',
        ];
    }

    public function save()
    {
        $this->choose_property = Collect($this->chooseProperty)->toArray();
        $this->spouse_information = Collect($this->spouseInformation)->toArray();
        $this->co_borrower_information = Collect($this->coBorrowerInformation)->toArray();
        $this->attorney_information = Collect($this->attorneyInformation)->toArray();
        $this->location = Collect($this->choose_property['selectedLocation'])->toArray();
        
        $documents = Document::all();

        $property = Property::withoutGlobalScope('default_branch')
                        ->where('location_id', $this->location['location_id'])
                        ->where('block', $this->location['block'])
                        ->where('lot', $this->location['lot'])
                        ->first();

        if ($property) {
            $buyer = $this->createBuyer();   

            $spouse = $this->createSpouse($buyer);   

            $co_borrower = $this->createCoBorrower($buyer);

            $attorney = $this->createAttorney();

            $property_attr = $this->choose_property;
            $property_attr['property_id'] = $property->id;
            $property_attr['co_borrower_id'] = $co_borrower->id;
            $property_attr['attorney_id'] = $attorney->id;
            $property_attr['contract_price'] = $property->contract_price;
            $property_attr['default_monthly_amortization'] = $property->default_monthly_amortization;
            $property_attr['term'] = $property->term;

            $buyer->reservations()->create($property_attr);

            foreach ($documents as $document) {
                if ($this->hasFile($document->title)) {
                    $file = $this->file($document->title);
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $file->storeAs('buyers/' . $buyer->id . '/' . $document->title, $filename, 's3');
        
                    $buyer->documents()->attach($document->id, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        } else {
            abort(402, 'Property is not available');
        }
    }

    protected function createBuyer()
    {
        $role = Role::where('name', 'buyer')->first();
        $name = $this->personal_information['first_name'] . ' ' . $this->personal_information['last_name'];
        $slug = SlugService::createSlug(User::class, 'slug', $name);

        $buyer = User::create([
            "branch_id" => $this->branch_id,
            "role_id" => $role->id,
            "name" => $name,
            "email" => $this->personal_information['email'],
            "slug" => $slug,
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

        Profile::create($profile_info);
    }

    protected function createSpouse($buyer)
    {
        if (isset($this->spouse_information)) {
            return $buyer->spouses()->create($this->spouse_information);
        }

        return false;
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
