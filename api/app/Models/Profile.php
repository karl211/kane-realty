<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $appends = ['full_name'];

    protected $fillable = [
        'user_id',
        'profile_type',
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'gender',
        'tin',
        'date_of_birth',
        'civil_status',
        'religion',
        'contact_number',
        'zip_code',
        'address',
        'facebook_url',
        'instagram_url',
        'spouse_first_name',
        'spouse_last_name',
        'spouse_middle_name',
        'spouse_date_of_birth',
        'spouse_gender',
        'spouse_tin',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
