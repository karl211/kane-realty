<?php

namespace Database\Seeders\Old;

use App\Models\Role;
use App\Models\Branch;
use App\Models\Profile;
use App\Models\Location;
use App\Models\Property;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\Old\\ReservationSeeder"
        
        $reservations = DB::connection('mysql2')->select("
        SELECT
            DISTINCT
            new_reservations.*
        FROM
            new_reservations
        WHERE
            new_reservations.location IS NOT NULL and last_name is not NULL
        ");

        foreach ($reservations as $reservation) {
            if ($reservation->first_name && $reservation->last_name) {
                $profile = Profile::withoutGlobalScope('default_branch')
                    ->where('first_name', trim(ucfirst(strtolower($reservation->first_name))))
                    ->where('last_name', trim(ucfirst(strtolower($reservation->last_name))))
                    ->first();

                if ($profile) {
                    $location = Location::withoutGlobalScope('default_branch')
                        ->where('location', ucfirst(strtolower($reservation->location)))
                        ->first();

                    $property = Property::withoutGlobalScope('default_branch')
                        ->where('location_id', $location->id)
                        ->where('block', $reservation->block)
                        ->where('lot', $reservation->lot)
                        ->first();

                    if ($property) {
                        $co_borrower_id = null;
                        $buyer = $profile->buyer;
            
                        if ($buyer->coBorrowers()->first()) {
                            $co_borrower_id = $buyer->coBorrowers()->first()->id;
                        }
            
                        if ($reservation->transaction_at && $reservation->contract_price && $reservation->term && $reservation->monthly_amortization) {
                            $new_reservation = Reservation::withoutGlobalScope('default_branch')
                            ->updateOrCreate([
                                'buyer_id' => $buyer->id,
                                'co_borrower_id' => $co_borrower_id,
                                'property_id' => $property->id
                            ], [
                                'contract_price' => $reservation->contract_price,
                                'monthly_amortization' => $reservation->monthly_amortization,
                                'term' => $reservation->term,
                                'transaction_at' => $reservation->transaction_at,
                                'status' => trim(ucwords(strtolower($reservation->status))),
                            ]);
                        }
                    }
                }
            }
        }
    }
}









// <?php

// namespace Database\Seeders\Old;

// use App\Models\Role;
// use App\Models\Branch;
// use App\Models\Profile;
// use App\Models\Location;
// use App\Models\Property;
// use App\Models\Reservation;
// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// class ReservationSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      *
//      * @return void
//      */
//     public function run()
//     {
       
//         $reservations = DB::connection('mysql2')->select("
//         SELECT
//             new_properties.*
//         FROM
//             new_properties
//         ");

//         foreach ($reservations as $reservation) {
//             $profile = Profile::withoutGlobalScope('default_branch')
//                 ->where('first_name', ucwords($reservation->first_name))
//                 ->where('last_name', ucwords($reservation->last_name))
//                 ->where('middle_name', ucwords($reservation->middle_name))
//                 ->first();
//             $location = Location::withoutGlobalScope('default_branch')
//                 ->where('location', $reservation->location)
//                 ->first();

//             $str = str_replace("block", "", strtolower($reservation->property));
//             $str = str_replace("lot", "", $str);
//             $explode_str = explode(' ', $str);

//             $block = null;
//             $lot = null;
//             $status = $reservation->status;

//             foreach ($explode_str as $val) {
//                 if ($val && !$block) {
                    
//                     $block = trim($val);
//                 } else if ($val && !$lot) {
//                     $lot = trim($val);
//                 }
//             }

//             if ($reservation->property == 'Block7 l0t5') {
//                 $block = 7;
//                 $lot = 5;
//             }
//             if ($reservation->property == 'B5 Lot9') {
//                 $block = 5;
//                 $lot = 9;
//             }

            
//             if ($reservation->property == 'bolck 3 lot5') {
//                 $block = 3;
//                 $lot = 5;
//             }

//             if ($reservation->property == 'Block 1lot1') {
//                 $block = 1;
//                 $lot = 1;
//             }
//             if ($reservation->property == 'block 2lot7') {
//                 $block = 2;
//                 $lot = 7;
//             }

//             if ($location) {
//                 $property = Property::withoutGlobalScope('default_branch')
//                     ->where('location_id', $location->id)
//                     ->where('block', $block)
//                     ->where('lot', $lot)
//                     ->first();
//                 if ($property) {
//                     $property->update([
//                         'status' => $reservation->status
//                     ]);
                    
//                     $co_borrower_id = null;
//                     $buyer = null;
                    
//                     if ($profile) {
//                         $buyer = $profile->buyer;
        
//                         $branch = 2;
//                         $butuan = array("San Vicente", "Tiniwisan");
        
//                         if (in_array($location->location, $butuan)) {
//                             $branch = 1;
//                         }
        
//                         $buyer->update([
//                             'branch_id' => $branch
//                         ]);
//                     }
        
//                     // if ($buyer->coBorrowers()->first()) {
//                     //     $co_borrower_id = $buyer->coBorrowers()->first()->id;
//                     // }
        
//                     if ($reservation->status == 'Completed') {
//                         $status = 'Fully Paid';
        
//                         $property->update([
//                             'status' => 'Fully Paid'
//                         ]);
//                     }
                    
//                     if ($buyer) {
//                         $new_reservation = Reservation::withoutGlobalScope('default_branch')
//                         ->updateOrCreate([
//                             'buyer_id' => $buyer->id,
//                             'co_borrower_id' => $co_borrower_id,
//                             'property_id' => $property->id
//                         ], [
//                             'contract_price' => $reservation->contract_price,
//                             'monthly_amortization' => $reservation->monthly_amortization,
//                             'term' => $reservation->term,
//                             'transaction_at' => now(),
//                             'status' => $status,
//                         ]);
            
//                         $new_reservation->payments()->withoutGlobalScope('default_branch')
//                         ->updateOrCreate([
//                             'buyer_id' => $buyer->id,
//                             'or_number' => $reservation->ORNumber,
//                             'type_of_payment' => $reservation->TypeOfPayment,
//                             'mode_of_payment' => $reservation->ModeOfPayment
//                         ], [
//                             'amount' => $reservation->Amount,
//                             'paid_at' => $reservation->DateOfPayment,
//                         ]);
//                     }
                    
//                 }
//             }
            
            
//         }
//     }
// }
