<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkSalesManager extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(User::class, 'manager_id');

        // return $this->belongsToMany(User::class, NetworkSalesManager::class, 'network_id', 'manager_id')->with('profile')->withTimestamps();
    }
}
