<?php

namespace Database\Seeders\Old;

use App\Models\Role;
use App\Models\User;
use App\Models\Network;
use App\Models\Document;
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
        // php artisan db:seed --class="Database\\Seeders\\Old\\UserSeeder"
        $users = DB::connection('mysql2')->select("
        SELECT
            clients.*, 
            transactions.ContractPrice, 
            transactions.MonthlyAmortization, 
            transactions.Terms, 
            transactions.`Status`, 
            properties.`Name`, 
            properties.Description, 
            properties.Location, 
            properties.`Status`
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
        ");

        foreach ($users as $user) {
            dd($user);
        }
    }
}
