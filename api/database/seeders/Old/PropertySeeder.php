<?php

namespace Database\Seeders\Old;

use App\Models\Role;
use App\Models\Branch;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\Old\\PropertySeeder"
        

        $properties = DB::connection('mysql2')->select("
        SELECT
            propertytypes.`Name` as location_name, 
            propertytypes.`Location` as description, 
            propertytypes.`Description` as type, 
            properties.`Name` as property, 
            properties.Description as lot_size, 
            properties.`Status`,
            transactions.ContractPrice, 
            transactions.MonthlyAmortization, 
            transactions.Terms, 
            transactions.`Status`
        FROM
            propertytypes
            INNER JOIN
            properties
            ON 
                propertytypes.Id = properties.PropertyTypeId
            INNER JOIN
            transactions
            ON 
                properties.Id = transactions.PropertyId
            WHERE properties.`Name` != 'Test Property'
        ");
        
        
        foreach ($properties as $property) {
            $location = Location::withoutGlobalScope('default_branch')->where('location', $property->location_name)->first();

            if ($location) {
                $str = str_replace("block", "", strtolower($property->property));
                $str = str_replace("lot", "", $str);
                $explode_str = explode(' ', $str);

                $block = null;
                $lot = null;

                foreach ($explode_str as $val) {
                    if ($val && !$block) {
                        
                        $block = trim($val);
                    } else if ($val && !$lot) {
                        // dd($val);
                        $lot = trim($val);
                    }
                }

                // if ($block == 'b5') {
                //     dd($property);
                // }
                if ($property->property == 'Block7 l0t5') {
                    $block = 7;
                    $lot = 5;
                }
                if ($property->property == 'B5 Lot9') {
                    $block = 5;
                    $lot = 9;
                }

                
                if ($property->property == 'bolck 3 lot5') {
                    $block = 3;
                    $lot = 5;
                }

                if ($property->property == 'Block 1lot1') {
                    $block = 1;
                    $lot = 1;
                }
                if ($property->property == 'block 2lot7') {
                    $block = 2;
                    $lot = 7;
                }

                // if (!$lot) {
                //     dd($property);
                // }
                
                // $location = Location::updateOrCreate(
                // [
                //     'branch_id' => $branch,
                    
                // ], [
                //     'location' => $property->location_name,
                //     'description' => $property->description,
                //     'type' => $property->type,
                // ]);

                $location->properties()->updateOrCreate([
                    'block' => $block,
                    'lot' => $lot,
                    'lot_size' => $property->lot_size,
                    'contract_price' => $property->ContractPrice,
                    'default_monthly_amortization' => $property->MonthlyAmortization,
                    'term' => $property->Terms,
                    'photo' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
                    'status' => $property->Status,
                ]);
            }
            
        }

        
    }
}
