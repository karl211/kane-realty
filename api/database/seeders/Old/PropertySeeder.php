<?php

namespace Database\Seeders\Old;

use App\Models\Role;
use App\Models\Branch;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\Old\\PropertySeeder"
        

        $properties = DB::connection('mysql2')->select("
        SELECT DISTINCT
            new_reservations.location, 
            new_reservations.block, 
            new_reservations.lot, 
            new_reservations.`status`, 
            new_reservations.contract_price, 
            new_reservations.monthly_amortization, 
            new_reservations.term,
            new_reservations.sqm
        FROM
            new_reservations
            WHERE new_reservations.location is not null
            ORDER BY location
        ");
        
        foreach ($properties as $property) {
            $location = Location::withoutGlobalScope('default_branch')->where('location', $property->location)->first();

            if ($location) {
                $location->properties()->withoutGlobalScope('default_branch')->updateOrCreate([
                    'block' => $property->block,
                    'lot' => $property->lot,
                    'lot_size' => $property->sqm . ' sqm',
                    'contract_price' => $property->contract_price,
                    'default_monthly_amortization' => $property->monthly_amortization,
                    'term' => $property->term,
                    'status' => ucfirst(strtolower($property->status)),
                    'is_active' => true,
                ]);
            }
        }
    }
}
