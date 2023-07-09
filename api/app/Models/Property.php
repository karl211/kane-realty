<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'location_id',
        'block',
        'lot',
        'phase',
        'lot_size',
        'floor_area',
        'model',
        'photo',
        'description',
        'contract_price',
        'default_monthly_amortization',
        'term',
        'status',
        'is_active',
        'deleted_at',
    ];

    protected $appends = ['full_property'];

    protected static function booted()
    {
        if (request()->branch_id) {
            static::addGlobalScope('default_branch', function (Builder $builder) {
                if (request()->branch_id) {
                    $branch = request()->branch_id;
    
                    if (Str::isJson($branch)) {
                        $branch = json_decode($branch);
                    }
    
                    $builder->whereHas('location', function($q) use ($branch) {
                        $q->where('branch_id', $branch);
                    });
                }
            });
        }
    }

    public function getFullPropertyAttribute()
    {
        return $this->location->location . ' - Block ' . $this->block . ', Lot ' . $this->lot . ', Phase ' . $this->phase;
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function reservations()
    {
        return $this->belongsTo(Reservation::class, 'property_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) {
            $query->where('status', request('search'));
        });
    }
}
