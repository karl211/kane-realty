<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\Old\UserSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\Old\PaymentSeeder;
use Database\Seeders\Old\LocationSeeder;
use Database\Seeders\Old\PropertySeeder;
use Database\Seeders\Old\ReservationSeeder;
use Database\Seeders\Old\SalesManagerSeeder;
use Database\Seeders\Old\BuyerDocumentSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BranchSeeder::class,
            LocationSeeder::class,
            PropertySeeder::class,
            DocumentSeeder::class,
            
            UserSeeder::class,
            PermissionSeeder::class,
            ReservationSeeder::class,
            PaymentSeeder::class,
            // BuyerDocumentSeeder::class,
            // SalesManagerSeeder::class,
        ]);
    }
}
