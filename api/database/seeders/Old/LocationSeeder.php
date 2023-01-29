<?php

namespace Database\Seeders\Old;

use App\Models\Role;
use App\Models\Branch;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\Old\\LocationSeeder"
        
        $roles = [
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'cashier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'sales manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'sales agent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'buyer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'bookkeeper',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($roles);

        $locations = DB::connection('mysql2')->select("
        SELECT DISTINCT
            new_reservations.location
        FROM
            new_reservations
            WHERE location is not null
        ");

        foreach ($locations as $location) {
            $branch = 2;
            $butuan = array("san vicente", "tiniwisan");
            $map = 'https://maps.google.com/maps?q='. $location->location .'&z=14&ie=UTF8&iwloc=&output=embed';

            if (in_array(strtolower($location->location), $butuan)) {
                $branch = 1;
            }

            Location::create([
                'branch_id' => $branch,
                'location' => ucwords(strtolower($location->location)),
                'description' => isset($location->description) ? $location->description : 'none',
                'type' => isset($location->type) ? $location->type : 'none',
                'map' => $map,
            ]);

        }
    }
}
