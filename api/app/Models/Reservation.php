<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['balance'];

    protected $fillable = [
        'property_id',
        'buyer_id',
        'co_borrower_id',
        'attorney_id',
        'network_id',
        'sales_manager_id',
        'sales_agent_id',
        'contract_price',
        'monthly_amortization',
        'term',
        'transaction_at',
        'status',
    ];

    protected static function booted()
    {
        static::addGlobalScope('default_branch', function (Builder $builder) {
            if (request()->branch_id) {
                $branch = request()->branch_id;

                if (Str::isJson($branch)) {
                    $branch = json_decode($branch);
                }

                $builder->whereHas('property.location', function($q) use ($branch) {
                    $q->where('branch_id', $branch)->where('id', request()->location_id);
                });
            }
        });
    }

    public function getBalanceAttribute()
    {
        return ($this->contract_price / 100) - ($this->payments->pluck('amount')->sum() / 100);
    }

    // public function getFullPropertyAttribute()
    // {
    //     return $this->location->location . ' - Block ' . $this->block . ', Lot ' . $this->lot . ', Phase ' . $this->phase;
    // }

    // /**
    //  * Get the user's first name.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Casts\Attribute
    //  */
    // protected function monthlyAmortization(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             return $value + 10000;
    //         },
    //     );
    // }
    
    // public function sample()
    // {
    //     return $this->property->location->location . ' - Block ' . $this->property->block . ', Lot ' . $this->property->lot . ', Phase ' . $this->property->phase;
    // }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function sales_manager()
    {
        return $this->belongsTo(User::class, 'sales_manager_id');
    }

    public function sales_agent()
    {
        return $this->belongsTo(User::class, 'sales_agent_id');
    }

    public function attorney()
    {
        return $this->belongsTo(Attorney::class, 'attorney_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->whereHas('buyer', function ($query) use ($search) {
                return $query->where('email', $search);
            })
            ->orWhereHas('buyer.profile', function ($query) use ($search) {
                return $query->where('first_name', $search)
                    ->orWhere('middle_name', $search)
                    ->orWhere('last_name', $search)
                    ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%".$search."%");
            });
        }
        return $query;
    }
}
