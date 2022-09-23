<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ar_number',
        'amount',
        'type_of_payment',
        'mode_of_payment',
        'paid_at',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) {
            $query->whereHas('reservation.buyer.profile', function ($query) {
                return $query->where('first_name', request('search'))
                    ->orWhere('first_name', request('search'))
                    ->orWhere('last_name', request('search'))
                    ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%".request('search')."%");
            })
            ->orWhere('ar_number', request('search'));
        });
    }
}
