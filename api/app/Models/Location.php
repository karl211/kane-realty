<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['location'];

    public function properties()
    {
        return $this->hasMany(Property::class)
            ->orderBy('block', 'ASC');
    }
}
