<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Location;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Location::factory(8)->create(); 

        \App\Models\Property::factory(500)->create(); 
        // Location::factory()
        //     ->count(100)
        //     ->hasAttached(
        //         Property::factory()->count(20),
        //         [
        //             'updated_at' => Carbon::now(),
        //             'created_at' => Carbon::now(),
        //         ]
        //     )
        //     ->create();
    }
}
