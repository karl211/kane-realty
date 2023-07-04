<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch_id',
        'email',
        'password',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function salesManagerAgents()
    {
        return $this->belongsToMany(User::class, 'sales_manager_agents', 'manager_id', 'agent_id');
    }
    
    public function spouses()
    {
        return $this->hasMany(Spouse::class, 'buyer_id');
    }

    public function coBorrowers()
    {
        return $this->hasMany(BuyerCoBorrower::class, 'buyer_id');
    }

    public function employmentStatus()
    {
        return $this->hasOne(EmploymentStatus::class, 'buyer_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'buyer_id');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'buyer_documents', 'buyer_id', 'document_id')->withPivot('file', 'buyer_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) {
            $query->whereHas('profile', function ($query) {
                return $query->where('first_name', request('search'))
                    ->orWhere('first_name', request('search'))
                    ->orWhere('last_name', request('search'))
                    ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%".request('search')."%");
            });
        });
    }
    
}
