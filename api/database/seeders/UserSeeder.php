<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Network;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\SalesManagerAgent;
use Illuminate\Support\Facades\DB;
use App\Models\NetworkSalesManager;
use Illuminate\Support\Facades\Hash;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(5000)->create(); 
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

        $networks = [
            ['name' => 'Camella','created_at' => now(), 'updated_at' => now()],
            ['name' => 'Red Valley','created_at' => now(), 'updated_at' => now()],
            ['name' => 'VCDU Realty','created_at' => now(), 'updated_at' => now()],
            ['name' => 'DK Realty','created_at' => now(), 'updated_at' => now()],
            ['name' => 'Leuterio Realty & Brokerage','created_at' => now(), 'updated_at' => now()]
        ];

        Role::insert($roles);

        Network::insert($networks);
        
        $slug = SlugService::createSlug(User::class, 'slug', 'Super Admin');

        $users =  [
            [
                'role_id' => 1,
                'name' => 'Super Admin',
                'email' => 'kane@admin.com',
                'email_verified_at' => now(),
                'slug' => $slug,
                'password' => Hash::make('secret123'), // password
                'remember_token' => Str::random(10),
            ],
        ];
        User::insert($users);

        $faker = \Faker\Factory::create();

        for ($i=1; $i < 100; $i++) { 
            $name = $faker->name();
            $role = Role::inRandomOrder()->first();
            $slug = SlugService::createSlug(User::class, 'slug', $name);

            $user = User::create([
                "role_id" => $role->id,
                "name" => $name,
                "email" => Str::random(10). '@gmail.com',
                'email_verified_at' => now(),
                'slug' => $slug,
                'password' => Hash::make('secret123'), // password
                'remember_token' => Str::random(10),
            ]);

            if ($role->id == 3) {
                NetworkSalesManager::insert([
                    "network_id" => Network::inRandomOrder()->first()->id,
                    "manager_id" => $user->id,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }

            if ($role->id == 4) {
                $manager = User::where('role_id', 3)->inRandomOrder()->first();

                if ($manager) {
                    SalesManagerAgent::insert([
                        "manager_id" => $manager->id,
                        "agent_id" => $user->id,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ]);
                }
            }
        }
    }
}
