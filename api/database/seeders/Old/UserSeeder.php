<?php

namespace Database\Seeders\Old;

use App\Models\User;
use App\Models\Attorney;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // php artisan db:seed --class="Database\\Seeders\\Old\\UserSeeder"
        

        $slug = SlugService::createSlug(User::class, 'slug', 'Super Admin');
        $users =  [
            [
                'role_id' => 1,
                'branch_id' => 1,
                'email' => 'kane@admin.com',
                'email_verified_at' => now(),
                'slug' => $slug,
                'password' => Hash::make('secret123'), // password
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'middle_name' => 'Admin',
            ],
            [
                'role_id' => 6,
                'branch_id' => 1,
                'email' => 'honeybeb@admin.com',
                'email_verified_at' => now(),
                'slug' => SlugService::createSlug(User::class, 'slug', 'Honeybeb Bookkeeper'),
                'password' => Hash::make('secret123'), // password
                'first_name' => 'Honey Beb',
                'last_name' => 'Admin',
                'middle_name' => 'Admin',
            ],
            [
                'role_id' => 6,
                'branch_id' => 1,
                'email' => 'rose@admin.com',
                'email_verified_at' => now(),
                'slug' => SlugService::createSlug(User::class, 'slug', 'Rose Bookkeeper'),
                'password' => Hash::make('secret123'), // password
                'first_name' => 'Rose',
                'last_name' => 'Admin',
                'middle_name' => 'Admin',
            ],
        ];

        foreach ($users as $user) {
            $admin = User::create([
                'role_id' => $user['role_id'],
                'branch_id' => $user['branch_id'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'slug' => $user['slug'],
                'password' => $user['password']
            ]);

            $admin->profile()->withoutGlobalScope('default_branch')
            ->updateOrCreate([
                'first_name' => ucwords(trim($user['first_name'])),
                'last_name' => ucwords(trim($user['last_name'])),
                'middle_name' => ($user['middle_name']) ? ucwords(trim($user['middle_name'])) : null
            ], [
                'photo' => null
            ]);
        }
        

        $users = DB::connection('mysql2')->select("
        SELECT DISTINCT
            TRIM(new_reservations.first_name) AS first_name, 
            TRIM(new_reservations.last_name) AS last_name, 
            TRIM(new_reservations.middle_name) AS middle_name, 
            TRIM(new_reservations.suffix) AS suffix, 
            new_reservations.email, 
            new_reservations.date_of_birth, 
            new_reservations.age, 
            new_reservations.gender, 
            new_reservations.civil_status, 
            new_reservations.religion, 
            new_reservations.tin, 
            new_reservations.address, 
            new_reservations.zip_code, 
            new_reservations.contact_number, 
            new_reservations.facebook_url, 
            new_reservations.instagram_url, 
            new_reservations.spouse_last_name, 
            new_reservations.spouse_first_name, 
            new_reservations.spouse_middle_name, 
            new_reservations.spouse_suffix, 
            new_reservations.spouse_gender, 
            new_reservations.spouse_date_of_birth, 
            new_reservations.spouse_age, 
            new_reservations.spouse_contact_number, 
            new_reservations.spouse_tin, 
            new_reservations.location, 
            new_reservations.co_borrower_last_name, 
            new_reservations.co_borrower_first_name, 
            new_reservations.co_borrower_middle_name, 
            new_reservations.co_borrower_suffix, 
            new_reservations.co_borrower_gender, 
            new_reservations.co_borrower_tin, 
            new_reservations.co_borrower_date_of_birth, 
            new_reservations.co_borrower_contact_number, 
            new_reservations.attorney_last_name, 
            new_reservations.attorney_first_name, 
            new_reservations.attorney_middle_name, 
            new_reservations.attorney_suffix, 
            new_reservations.attorney_gender, 
            new_reservations.attorney_tin, 
            new_reservations.attorney_date_of_birth, 
            new_reservations.attorney_contact_number, 
            new_reservations.network_name, 
            new_reservations.manager_last_name, 
            new_reservations.manager_first_name, 
            new_reservations.manager_middle_name, 
            new_reservations.agent_last_name, 
            new_reservations.agent_first_name, 
            new_reservations.agent_middle_name
        FROM
            new_reservations
        WHERE
            last_name IS NOT NULL
        ORDER BY
            last_name ASC
        ");

        foreach ($users as $user) {
            $name = ucwords(trim($user->first_name))  . ' ' . ucwords(trim($user->middle_name)) . ' ' . ucwords(trim($user->last_name));
            $slug = SlugService::createSlug(User::class, 'slug', $name);
            $email = ucwords(trim($user->first_name))  . '_' . ucwords(trim($user->middle_name)) . '_' . ucwords(trim($user->last_name)) . '@gamil.com';

            $branch = 2;
            $butuan = array("San Vicente", "Tiniwisan");

            if (in_array(ucwords(strtolower($user->location)), $butuan)) {
                $branch = 1;
            }
            
            $user_data = User::updateOrCreate([
                "role_id" => 5,
                'branch_id' => $branch,
                'email' => $email
            ], [
                'slug' => $slug,
                'password' => Hash::make('secretpass' . strtolower($user->last_name)), // password
            ]);

            $user_data->profile()->withoutGlobalScope('default_branch')
            ->updateOrCreate([
                'first_name' => ucwords(trim($user->first_name)),
                'last_name' => ucwords(trim($user->last_name)),
                'middle_name' => ($user->middle_name) ? ucwords(trim($user->middle_name)) : null
            ], [
                'suffix' => ($user->suffix) ? ucwords(trim($user->suffix)) : null,
                'gender' => ($user->gender) ? ucwords(trim($user->gender)) : null,
                'tin' => ($user->tin) ? ucwords(trim($user->tin)) : null,
                'date_of_birth' => ($user->date_of_birth) ? ucwords(trim($user->date_of_birth)) : null,
                'civil_status' => ($user->civil_status) ? ucwords(trim($user->civil_status)) : null,
                'religion' => ($user->religion) ? ucwords(trim($user->religion)) : null,
                'contact_number' => ($user->contact_number) ? ucwords(trim($user->contact_number)) : null,
                'zip_code' => ($user->zip_code) ? ucwords(trim($user->zip_code)) : null,
                'address' => ($user->address) ? ucwords(trim($user->address)) : null,
                'photo' => null
            ]);

            if ($user->spouse_first_name && $user->spouse_last_name) {
                $user_data->spouses()->withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'first_name' => ucwords($user->spouse_first_name),
                    'last_name' => ucwords($user->spouse_last_name),
                    'middle_name' => ($user->spouse_middle_name) ? ucwords(trim($user->spouse_middle_name)) : null
                ], [
                    'gender' => ($user->spouse_gender) ? ucwords(trim($user->spouse_gender)) : null,
                    'tin' => ($user->spouse_tin) ? ucwords(trim($user->spouse_tin)) : null,
                    'date_of_birth' => ($user->spouse_date_of_birth) ? ucwords(trim($user->spouse_date_of_birth)) : null,
                    'contact_number' => ($user->spouse_contact_number) ? ucwords(trim($user->spouse_contact_number)) : null
                ]);
            }

            if ($user->co_borrower_last_name && $user->co_borrower_first_name) {
                $user_data->coBorrowers()->withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'first_name' => ucwords($user->co_borrower_first_name),
                    'last_name' => ucwords($user->co_borrower_last_name)
                ], [
                    'middle_name' => ucwords($user->co_borrower_middle_name),
                    'suffix' => ucwords($user->co_borrower_suffix),
                    'gender' => ucwords($user->co_borrower_gender),
                    'tin' => ucwords($user->co_borrower_tin),
                    'date_of_birth' => $user->co_borrower_date_of_birth,
                    'contact_number' => ucwords($user->co_borrower_contact_number)
                ]);
            }

            if ($user->attorney_first_name && $user->attorney_last_name) {
                Attorney::withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'first_name' => ucwords($user->attorney_first_name),
                    'last_name' => ucwords($user->attorney_last_name)
                ],[
                    'middle_name' => ucwords($user->attorney_middle_name),
                    'suffix' => ucwords($user->attorney_suffix),
                    'gender' => ucwords($user->attorney_gender),
                    'tin' => ucwords($user->attorney_tin),
                    'date_of_birth' => $user->attorney_date_of_birth,
                    'contact_number' => ucwords($user->attorney_contact_number)
                ]);
            }
            
            // if ($user->Position) {
            //     $user_data->employmentStatus()->withoutGlobalScope('default_branch')
            //     ->updateOrCreate([
            //         'employment' => $user->Employment,
            //         'company_name' => $user->CompanyName,
            //         'location_of_work' => $user->CompanyLocation,
            //         'type_of_work' => $user->EmploymentType,
            //         'date_employed' => $user->DateEmployed,
            //         'profession' => $user->Profession,
            //         'position' => $user->Position,
            //     ]);
            // }
        }


    }
}
