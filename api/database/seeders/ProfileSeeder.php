<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Profile::factory(100)->create();

        \App\Models\BuyerCoBorrower::factory(100)->create(); 

        \App\Models\Attorney::factory(20)->create(); 
    }
}
