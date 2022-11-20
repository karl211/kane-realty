<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'spouse_suffix',
        'spouse_date_of_birth',
        'spouse_gender',
        'spouse_tin',
        'spouse_contact_number',
        'photo',
    ];

    protected static function booted()
    {
        static::addGlobalScope('default_branch', function (Builder $builder) {
            if (request()->branch_id) {
                $branch = request()->branch_id;

                if (Str::isJson($branch)) {
                    $branch = json_decode($branch);
                }

                $builder->whereHas('buyer', function($q) use ($branch) {
                    $q->where('branch_id', $branch);
                });
            }

            
        });
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullNameAttribute()
    {
        return $this->last_name . ', ' . $this->first_name . ' ' . ucfirst(substr($this->middle_name, 0, 1)) . '.';
    }
}
