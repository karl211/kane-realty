<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'employment',
        'company_name',
        'location_of_work',
        'type_of_work',
        'date_employed',
        'profession',
        'position',
        'business_name',
        'business_location',
        'business_industry',
        'business_date_establish',
        'business_type',
    ];
}
