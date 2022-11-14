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
            ],
        ];

        User::insert($users);

        $users = DB::connection('mysql2')->select("
        SELECT DISTINCT
        propertytypes.`Name`, 
        clients.SequenceNo, 
        clients.LastName, 
        clients.FirstName, 
        clients.MiddleName, 
        clients.Suffix, 
        clients.BirthDate, 
        clients.Gender, 
        clients.CivilStatus, 
        clients.Religion, 
        clients.TIN, 
        clients.ContactNumber, 
        clients.ZipCode, 
        clients.Address, 
        clients.Nationality, 
        clients.EducationalAttn, 
        clients.NumberOfDependents, 
        clients.School, 
        clients.MonthlyIncome, 
        clients.MonthlyHouseholdIncome, 
        clients.SpouseLastName, 
        clients.SpouseFirstName, 
        clients.SpouseMiddleName, 
        clients.SpouseBirthDate, 
        clients.SpouseGender, 
        clients.SpouseTIN, 
        clients.SpouseNumber, 
        clients.CoFirstName, 
        clients.CoLastName, 
        clients.CoMiddleName, 
        clients.CoSuffix, 
        clients.CoBirthDate, 
        clients.CoTIN, 
        clients.CoGender, 
        clients.CoNumber, 
        clients.AtLastName, 
        clients.AtFirstName, 
        clients.AtMiddleName, 
        clients.AtSuffix, 
        clients.AtBirthDate, 
        clients.AtGender, 
        clients.AtTIN, 
        clients.AtNumber, 
        clients.Employment, 
        clients.EmploymentType, 
        clients.CompanyName, 
        clients.Industry, 
        clients.CompanyLocation, 
        clients.DateEmployed, 
        clients.Profession, 
        clients.Position, 
        clients.HomeNumber, 
        clients.OfficeNumber
    FROM
        clients
        INNER JOIN
        transactions
        ON 
            clients.Id = transactions.ClientId
        INNER JOIN
        properties
        ON 
            transactions.PropertyId = properties.Id
        INNER JOIN
        propertytypes
        ON 
            properties.PropertyTypeId = propertytypes.Id
    WHERE
        FirstName IS NOT NULL
        ");

        foreach ($users as $user) {
            $name = ucwords($user->FirstName)  . ' ' . ucwords($user->MiddleName) . ' ' . ucwords($user->LastName);
            $slug = SlugService::createSlug(User::class, 'slug', $name);
            $date_of_birth = $user->BirthDate;

            $user_data = User::updateOrCreate([
                "role_id" => 5,
                'branch_id' => 1,
                'email' => $slug .'@gamil.com',
                'slug' => $slug
            ], [
                'password' => Hash::make('secretpass' . strtolower($user->LastName)), // password
            ]);

            if (
                $user->BirthDate == '0001-01-02 00:00:00.000000' || 
                $user->BirthDate == '0001-01-02 07:52:58.000000' ||
                $user->BirthDate == '0001-01-01 00:00:00.000000' ||
                $user->BirthDate == '0001-01-01 15:56:00.000000' ||
                $user->BirthDate == '0001-01-02 15:56:00.000000' 
            ) {
                $date_of_birth = null;
            }

            $user_data->profile()->withoutGlobalScope('default_branch')
            ->updateOrCreate([
                'first_name' => ucwords($user->FirstName),
                'last_name' => ucwords($user->LastName),
                'middle_name' => ucwords($user->MiddleName)
            ], [
                'suffix' => ucwords($user->Suffix),
                'gender' => ucwords($user->Gender),
                'tin' => ucwords($user->TIN),
                'date_of_birth' => $date_of_birth,
                'civil_status' => ucwords($user->CivilStatus),
                'religion' => ucwords($user->Religion),
                'contact_number' => ucwords($user->ContactNumber),
                'zip_code' => ucwords($user->ZipCode),
                'address' => ucwords($user->Address),
                'photo' => null,
            ]);

            if ($user->SpouseFirstName && $user->SpouseLastName) {
                $user_data->spouses()->withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'first_name' => ucwords($user->SpouseFirstName),
                    'last_name' => ucwords($user->SpouseLastName)
                ], [
                    'middle_name' => ucwords($user->SpouseMiddleName),
                    'gender' => ucwords($user->SpouseGender),
                    'tin' => ucwords($user->SpouseTIN),
                    'date_of_birth' => $user->SpouseBirthDate,
                    'contact_number' => ucwords($user->SpouseNumber)
                ]);
            }
            
            if ($user->CoFirstName && $user->CoLastName) {
                $user_data->coBorrowers()->withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'first_name' => ucwords($user->CoFirstName),
                    'last_name' => ucwords($user->CoLastName)
                ], [
                    'middle_name' => ucwords($user->SpouseMiddleName),
                    'suffix' => ucwords($user->CoSuffix),
                    'gender' => ucwords($user->CoGender),
                    'tin' => ucwords($user->CoTIN),
                    'date_of_birth' => $user->CoBirthDate,
                    'contact_number' => ucwords($user->CoNumber)
                ]);
            }

            if ($user->CoFirstName && $user->CoLastName) {
                $user_data->coBorrowers()->withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'first_name' => ucwords($user->CoFirstName),
                    'last_name' => ucwords($user->CoLastName)
                ], [
                    'middle_name' => ucwords($user->SpouseMiddleName),
                    'suffix' => ucwords($user->CoSuffix),
                    'gender' => ucwords($user->CoGender),
                    'tin' => ucwords($user->CoTIN),
                    'date_of_birth' => $user->CoBirthDate,
                    'contact_number' => ucwords($user->CoNumber)
                ]);
            }

            if ($user->AtFirstName && $user->AtLastName) {
                Attorney::withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'first_name' => ucwords($user->AtFirstName),
                    'last_name' => ucwords($user->AtLastName)
                ],[
                    'middle_name' => ucwords($user->AtMiddleName),
                    'suffix' => ucwords($user->AtSuffix),
                    'gender' => ucwords($user->AtGender),
                    'tin' => ucwords($user->AtTIN),
                    'date_of_birth' => $user->AtBirthDate,
                    'contact_number' => ucwords($user->AtNumber)
                ]);
            }
            
            if ($user->Position) {
                $user_data->employmentStatus()->withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'employment' => $user->Employment,
                    'company_name' => $user->CompanyName,
                    'location_of_work' => $user->CompanyLocation,
                    'type_of_work' => $user->EmploymentType,
                    'date_employed' => $user->DateEmployed,
                    'profession' => $user->Profession,
                    'position' => $user->Position,
                ]);
            }
            
        }
    }
}
