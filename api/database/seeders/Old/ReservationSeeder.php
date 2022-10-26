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
            clients.LastName, 
            clients.FirstName, 
            clients.MiddleName, 
            transactions.ContractPrice, 
            transactions.MonthlyAmortization, 
            transactions.Terms, 
            transactions.`Status`, 
            properties.`Name`, 
            properties.`Status` AS property_status, 
            propertytypes.`Name` AS location_name, 
            transactions.CreatedAt, 
            payments.SequenceNo, 
            payments.ORNumber, 
            payments.Amount, 
            payments.ModeOfPayment, 
            payments.DateOfPayment, 
            payments.CheckNo, 
            payments.BankName, 
            payments.Branch, 
            payments.InPaymentOf, 
            payments.TypeOfPayment
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
            INNER JOIN
            payments
            ON 
                transactions.Id = payments.TransactionId
        WHERE
            properties.`Name` <> 'Test Property' AND
            FirstName IS NOT NULL
        ");

        foreach ($reservations as $reservation) {
            $profile = Profile::withoutGlobalScope('default_branch')
                ->where('first_name', ucwords($reservation->FirstName))
                ->where('last_name', ucwords($reservation->LastName))
                ->where('middle_name', ucwords($reservation->MiddleName))
                ->first();
            $location = Location::withoutGlobalScope('default_branch')
                ->where('location', $reservation->location_name)
                ->first();

            $str = str_replace("block", "", strtolower($reservation->Name));
            $str = str_replace("lot", "", $str);
            $explode_str = explode(' ', $str);

            $block = null;
            $lot = null;

            foreach ($explode_str as $val) {
                if ($val && !$block) {
                    
                    $block = trim($val);
                } else if ($val && !$lot) {
                    $lot = trim($val);
                }
            }

            if ($reservation->Name == 'Block7 l0t5') {
                $block = 7;
                $lot = 5;
            }
            if ($reservation->Name == 'B5 Lot9') {
                $block = 5;
                $lot = 9;
            }

            
            if ($reservation->Name == 'bolck 3 lot5') {
                $block = 3;
                $lot = 5;
            }

            if ($reservation->Name == 'Block 1lot1') {
                $block = 1;
                $lot = 1;
            }
            if ($reservation->Name == 'block 2lot7') {
                $block = 2;
                $lot = 7;
            }

            $property = Property::withoutGlobalScope('default_branch')
                ->where('location_id', $location->id)
                ->where('block', $block)
                ->where('lot', $lot)
                ->first();

            // dd($reservation);

            // if (!$property) {
            //     dd($reservation);
            // }
            
            
            $co_borrower_id = null;
            $buyer = null;
            
            if ($profile) {
                $buyer = $profile->buyer;

                $branch = 2;
                $butuan = array("San Vicente", "Tiniwisan");

                if (in_array($location->location, $butuan)) {
                    $branch = 1;
                }

                $buyer->update([
                    'branch_id' => $branch
                ]);
            }
            // dd($buyer);
            // if ($buyer) {
                
            // }

            // if (!$profile) {
            //     dd($reservation);
            // }

            if ($buyer->coBorrowers()->first()) {
                $co_borrower_id = $buyer->coBorrowers()->first()->id;
            }

            $new_reservation = Reservation::withoutGlobalScope('default_branch')
            ->updateOrCreate([
                'buyer_id' => $buyer->id,
                'co_borrower_id' => $co_borrower_id,
                'property_id' => $property->id
            ], [
                'contract_price' => $reservation->ContractPrice,
                'monthly_amortization' => $reservation->MonthlyAmortization,
                'term' => $reservation->Terms,
                'transaction_at' => $reservation->CreatedAt,
            ]);

            $new_reservation->payments()->withoutGlobalScope('default_branch')
            ->updateOrCreate([
                'buyer_id' => $buyer->id,
                'ar_number' => $reservation->ORNumber,
                'type_of_payment' => $reservation->TypeOfPayment,
                'mode_of_payment' => $reservation->ModeOfPayment
            ], [
                'amount' => $reservation->Amount,
                'paid_at' => $reservation->DateOfPayment,
                'image' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
            ]);
        }
    }
}
