<?php

namespace Database\Seeders\Old;

use App\Models\Role;
use App\Models\Branch;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Location;
use App\Models\Property;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\Old\\PaymentSeeder"
        
        // $payments = DB::connection('mysql2')->select("
        // SELECT
        //     clients.LastName, 
        //     clients.FirstName, 
        //     clients.MiddleName, 
        //     transactions.ContractPrice, 
        //     transactions.MonthlyAmortization, 
        //     transactions.Terms, 
        //     transactions.`Status`, 
        //     transactions.CreatedAt, 
        //     properties.`Name` AS property, 
        //     propertytypes.`Name` AS location_name, 
        //     payments.SequenceNo, 
        //     payments.ORNumber, 
        //     payments.Amount, 
        //     payments.ModeOfPayment, 
        //     payments.DateOfPayment, 
        //     payments.CheckNo, 
        //     payments.BankName, 
        //     payments.Branch, 
        //     payments.InPaymentOf
        // FROM
        //     clients
        //     INNER JOIN
        //     transactions
        //     ON 
        //         clients.Id = transactions.ClientId
        //     INNER JOIN
        //     payments
        //     ON 
        //         transactions.Id = payments.TransactionId
        //     INNER JOIN
        //     properties
        //     ON 
        //         transactions.PropertyId = properties.Id
        //     INNER JOIN
        //     propertytypes
        //     ON 
        //         properties.PropertyTypeId = propertytypes.Id
        // WHERE properties.`Name` != 'Test Property' and FirstName is not NULL
        // ");

        $payments = DB::connection('mysql2')->select("
                    SELECT
                        new_payments.*
                    FROM
                        new_payments"
                );

        

        foreach ($payments as $payment) {
            $location = Location::where('location', $payment->location)->first();
            $profile = Profile::withoutGlobalScope('default_branch')
                    ->where('first_name', ucwords($payment->buyer_first_name))
                    ->where('last_name', ucwords($payment->buyer_last_name))
                    ->first();

            if ($location && $profile) {
                $property = Property::where('location_id', $location->id)
                    ->where('block', $payment->block)
                    ->where('lot', $payment->lot)
                    ->first();

                if ($property) {
                    $reservation = Reservation::withoutGlobalScope('default_branch')
                        ->where('property_id', $property->id)
                        ->where('buyer_id', $profile->user_id)
                        ->first();
                    
                    if ($reservation) {
                        if ($payment->type_of_payment == 'Fully Paid') {
                            $reservation->update([
                                'status' => 'Fully Paid'
                            ]);
                        }

                        $reservation->payments()->withoutGlobalScope('default_branch')
                            ->updateOrCreate([
                                'buyer_id' => $profile->user_id,
                                'ar_number' => $payment->ar_number,
                                'type_of_payment' => trim(ucwords(strtolower($payment->type_of_payment))),
                                'mode_of_payment' => trim(ucwords(strtolower($payment->mode_of_payment)))
                            ], [
                                'or_number' => $payment->or_number,
                                'amount' => $payment->amount,
                                'paid_at' => $payment->date_of_payment,
                            ]);
                    }
                }
                

                
            }
            
            // Payment::updateOrCreate([
            //     'reservation_id' => $reservation->id,
            //     'buyer_id' => $reservation->buyer_id,
            //     'paid_at' => now(),
            //     'ar_number' => random_int(1000, 5000),
            //     'or_number' => random_int(1000, 5000),
            //     'amount' => random_int(20000, 40000),
            //     'type_of_payment' => fake()->randomElement(['Reservation', 'Amortization']),
            //     'mode_of_payment' => fake()->randomElement(['Cash', 'Cheque', 'Gcash', 'Maya', 'Paypal']),
            //     'image' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
            // ]);
        }
    }
}
