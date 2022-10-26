<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\Old\UserSeeder;
use Database\Seeders\Old\ReservationSeeder;
use Database\Seeders\Old\LocationSeeder;
use Database\Seeders\Old\PropertySeeder;
use Database\Seeders\Old\BuyerDocumentSeeder;
use Database\Seeders\Old\SalesManagerSeeder;

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
            ReservationSeeder::class,
            BuyerDocumentSeeder::class,
            SalesManagerSeeder::class,
        ]);
    }
}
