<?php

namespace Database\Seeders\Old;

use App\Models\Role;
use App\Models\User;
use App\Models\Branch;
use App\Models\Location;
use Illuminate\Database\Seeder;
use App\Models\SalesManagerAgent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalesManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\Old\\SalesManagerSeeder"
        

        $managers = DB::connection('mysql2')->select("
        SELECT DISTINCT
            aspnetusers.UserName, 
            aspnetusers.Email, 
            aspnetusers.PhoneNumber, 
            aspnetusers.LastName, 
            aspnetusers.FirstName, 
            aspnetusers.MiddleName, 
            aspnetusers.Suffix, 
            aspnetusers.BirthDate, 
            aspnetusers.Address, 
            transactions.SalesManagerId, 
            transactions.SalesAgentId
        FROM
            transactions
            INNER JOIN
            aspnetusers
            ON 
                transactions.SalesManagerId = aspnetusers.Id
        ");

        foreach ($managers as $manager) {
            $name = ucwords($manager->FirstName)  . ' ' . ucwords($manager->MiddleName) . ' ' . ucwords($manager->LastName);
            $slug = SlugService::createSlug(User::class, 'slug', $name);

            $agents = DB::connection('mysql2')->select("
            SELECT DISTINCT
                aspnetusers.UserName, 
                aspnetusers.Email, 
                aspnetusers.PhoneNumber, 
                aspnetusers.LastName, 
                aspnetusers.FirstName, 
                aspnetusers.MiddleName, 
                aspnetusers.Suffix, 
                aspnetusers.BirthDate, 
                aspnetusers.Address, 
                transactions.SalesManagerId, 
                transactions.SalesAgentId
            FROM
                transactions
                INNER JOIN
                aspnetusers
                ON 
                    transactions.SalesAgentId = aspnetusers.Id
                WHERE
                transactions.SalesAgentId != '00000000-0000-0000-0000-000000000000' and
                transactions.SalesManagerId = ?", [$manager->SalesManagerId]);

            $user_data = User::withoutGlobalScope('default_branch')
            ->updateOrCreate([
                'email' => $manager->Email
            ], [
                'slug' => $slug,
                'password' => Hash::make('secretpass' . strtolower($manager->LastName)), // password
            ]);

            $user_data->profile()->withoutGlobalScope('default_branch')
            ->updateOrCreate([
                'first_name' => ucwords($manager->FirstName),
                'last_name' => ucwords($manager->LastName),
                'middle_name' => ucwords($manager->MiddleName)
            ], [
                'suffix' => ucwords($manager->Suffix),
                'date_of_birth' => $manager->BirthDate,
                'contact_number' => ucwords($manager->PhoneNumber),
                'address' => ucwords($manager->Address),
                'photo' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
            ]);

            foreach ($agents as $agent) {
                $name = ucwords($agent->FirstName)  . ' ' . ucwords($agent->MiddleName) . ' ' . ucwords($agent->LastName);
                $slug = SlugService::createSlug(User::class, 'slug', $name);

                $agent_data = User::withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'email' => $agent->Email
                ], [
                    'slug' => $slug,
                    'password' => Hash::make('secretpass' . strtolower($agent->LastName)), // password
                ]);

                $agent_data->profile()->withoutGlobalScope('default_branch')
                ->updateOrCreate([
                    'first_name' => ucwords($agent->FirstName),
                    'last_name' => ucwords($agent->LastName),
                    'middle_name' => ucwords($agent->MiddleName)
                ], [
                    'suffix' => ucwords($agent->Suffix),
                    'date_of_birth' => $agent->BirthDate,
                    'contact_number' => ucwords($agent->PhoneNumber),
                    'address' => ucwords($agent->Address),
                    'photo' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
                ]);

                SalesManagerAgent::updateOrCreate([
                    "manager_id" => $user_data->id,
                    "agent_id" => $agent_data->id,
                ]);
            }
        }
    }
}
