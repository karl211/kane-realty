<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reservation_id',
        'buyer_id',
        'ar_number',
        'or_number',
        'amount',
        'type_of_payment',
        'mode_of_payment',
        'paid_at',
        'image',
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

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
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

    public function scopeTotal($query)
    {
        return $query->sum('amount');
    }

    
}
