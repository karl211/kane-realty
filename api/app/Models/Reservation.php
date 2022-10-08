<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
    ];

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

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
