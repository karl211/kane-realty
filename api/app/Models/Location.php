<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $fillable = ['branch_id', 'location', 'description', 'type', 'photo'];

    protected static function booted()
    {
        static::addGlobalScope('default_branch', function (Builder $builder) {
            $builder->where('branch_id', request()->branch_id);
        });
    }

    public function properties()
    {
        return $this->hasMany(Property::class)
            ->orderBy('block', 'ASC');
    }
}
