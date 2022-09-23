<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // public function locations()
    // {
    //     return $this->belongsToMany(Location::class, 'location_properties');
    // }

    protected $appends = ['full_property'];

    public function getFullPropertyAttribute()
    {
        return $this->location->location . ' - Block ' . $this->block . ', Lot ' . $this->lot . ', Phase ' . $this->phase;
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
