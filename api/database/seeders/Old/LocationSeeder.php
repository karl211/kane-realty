<?php

namespace Database\Seeders\Old;

// use App\Models\Role;
use App\Models\Branch;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
                'name' => 'admin', 'guard_name' => 'api'
            ],
            [
                'name' => 'cashier', 'guard_name' => 'api'
            ],
            [
                'name' => 'sales manager', 'guard_name' => 'api'
            ],
            [
                'name' => 'sales agent', 'guard_name' => 'api'
            ],
            [
                'name' => 'buyer', 'guard_name' => 'api'
            ],
            [
                'name' => 'bookkeeper', 'guard_name' => 'api'
            ],
        ];

        $permissions = [
            [
                'name' => 'dashboard', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'calendar', 
                'guard_name' => 'api',
                ''
            ],
            [
                'name' => 'reservations-list', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'reservations-show', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'reservations-edit', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'reservations-delete', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'receipts-list', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'receipts-show', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'receipts-edit', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'receipts-delete', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'locations', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'invoices', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'reports', 
                'guard_name' => 'api'
            ],
            [
                'name' => 'users', 
                'guard_name' => 'api'
            ],
        ];

        // Role::insert($roles);

        foreach ($roles as $role) {
            $role = Role::updateOrCreate($role);
            
            foreach ($permissions as $permission) {
                if ($role->name == 'cashier') {
                    $user_permissions = ['reservations-list', 'reservations-show', 'reservations-edit', 'reservations-delete'];

                    if (array_search($permission->name, $user_permissions)) {
                        $created_permission = Permission::updateOrCreate($permission);
                        $role->givePermissionTo($created_permission);
                    }
                } else {
                    $created_permission = Permission::updateOrCreate($permission);
                    $role->givePermissionTo($created_permission);
                }
            }
        }

        dd('test');

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
