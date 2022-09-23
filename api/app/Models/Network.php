<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Network extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function salesManagers()
    {
        // return $this->hasMany(NetworkSalesManager::class, 'network_id');

        // return $this->hasManyThrough(NetworkSalesManager::class, User::class, 'id', 'network_id');

        return $this->belongsToMany(User::class, 'network_sales_managers', 'network_id', 'manager_id');
    }
}
