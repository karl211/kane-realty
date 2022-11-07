<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'concept' => 'Arkea',
                'branch' => 'Butuan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'concept' => 'Arkea',
                'branch' => 'San Francisco',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        Branch::insert($branches);
    }
}
