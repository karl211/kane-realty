<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $fillable = ['branch_id', 'location', 'description', 'type', 'map'];

    protected static function booted()
    {
        static::addGlobalScope('default_branch', function (Builder $builder) {
            if (request()->branch_id) {
                $branch = request()->branch_id;

                if (Str::isJson($branch)) {
                    $branch = json_decode($branch);
                }

                $builder->where('branch_id', $branch);
            }
        });
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
