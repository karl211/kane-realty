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
        ];

        Role::insert($roles);

        $locations = DB::connection('mysql2')->select("
        SELECT
            propertytypes.*
        FROM
            propertytypes
        ");

        foreach ($locations as $location) {
            $branch = 2;
            $butuan = array("San Vicente", "Tiniwisan");
            $map = null;

            if (in_array($location->Name, $butuan)) {
                $branch = 1;
            }

            switch ($location->Name) {
                case 'Tiniwisan':
                    $map = "https://maps.google.com/maps?q=Tiniwisan,+Butuan+City,+Agusan+Del+Norte&z=14&ie=UTF8&iwloc=&output=embed";
                    break;
                case 'San Vicente':
                    $map = "https://maps.google.com/maps?q=San+Vicente,+Butuan+City,+Agusan+Del+Norte&z=14&ie=UTF8&iwloc=&output=embed";
                    break;
                case 'Wasian':
                    $map = "https://maps.google.com/maps?q=Wasi-an,+Rosario,+Agusan+del+Sur&z=14&ie=UTF8&iwloc=&output=embed";
                    break;
                case 'Dughan':
                    $map = "https://maps.google.com/maps?q=Dughan,+Barobo,+Surigao+del+Sur&z=14&ie=UTF8&iwloc=&output=embed";
                    break;
                case 'San Isidro 2':
                    $map = "https://maps.google.com/maps?q=San+Isidro,+San+Francisco,+Agusan+del+Sur&z=14&ie=UTF8&iwloc=&output=embed";
                    break;
                case 'San Isidro 1':
                    $map = "https://maps.google.com/maps?q=San+Isidro,+San+Francisco,+Agusan+del+Sur&z=14&ie=UTF8&iwloc=&output=embed";
                    break;
                case 'Patin-ay':
                    $map = "https://maps.google.com/maps?q=Patin-ay,+Agusan+del+Sur&z=14&ie=UTF8&iwloc=&output=embed";
                    break;
                case 'WASIAN PHASE2':
                    $map = "https://maps.google.com/maps?q=Barangay+Wasi-an&z=14&ie=UTF8&iwloc=&output=embed";
                    break;
            }

            Location::create([
                'branch_id' => $branch,
                'location' => $location->Name,
                'description' => $location->Location,
                'type' => $location->Description,
                'photo' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
                'map' => $map,
            ]);
        }
    }
}
