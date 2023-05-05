<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'particular',
        'date',
        'receipt_no',
        'image',
        'agents_commission_san_vicente',
        'agents_commission_tiniwisan',
        'salary',
        'office_rental_expense',
        'utility_expense',
        'fuel_gasoline',
        'office_materials',
        'repair_maintenance',
        'representation_expense',
        'transportation',
        'retainers',
        'lot_cancellation',
        'web_system_development',
        'professional_fee',
        'processing_fee',
        'equipment',
        'others',
    ];

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

    // public function particular()
    // {
    //     return $this->belongsTo(Particular::class);
    // }

    
}
