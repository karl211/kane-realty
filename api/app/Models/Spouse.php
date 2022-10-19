<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'gender',
        'tin',
        'date_of_birth',
        'contact_number',
    ];
}
