<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $appends = ['full_property'];

    protected static function booted()
    {
        static::addGlobalScope('default_branch', function (Builder $builder) {
            $builder->whereHas('location', function($q) {
                $q->where('branch_id', request()->branch_id);
            });
        });
    }

    public function getFullPropertyAttribute()
    {
        return $this->location->location . ' - Block ' . $this->block . ', Lot ' . $this->lot . ', Phase ' . $this->phase;
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
