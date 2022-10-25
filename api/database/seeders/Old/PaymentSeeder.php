<?php

namespace Database\Seeders\Old;

use App\Models\Role;
use App\Models\Branch;
use App\Models\Payment;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\Old\\LocationSeeder"
        
        $payments = DB::connection('mysql2')->select("
        SELECT
            clients.LastName, 
            clients.FirstName, 
            clients.MiddleName, 
            transactions.ContractPrice, 
            transactions.MonthlyAmortization, 
            transactions.Terms, 
            transactions.`Status`, 
            transactions.CreatedAt, 
            properties.`Name` AS property, 
            propertytypes.`Name` AS location_name, 
            payments.SequenceNo, 
            payments.ORNumber, 
            payments.Amount, 
            payments.ModeOfPayment, 
            payments.DateOfPayment, 
            payments.CheckNo, 
            payments.BankName, 
            payments.Branch, 
            payments.InPaymentOf
        FROM
            clients
            INNER JOIN
            transactions
            ON 
                clients.Id = transactions.ClientId
            INNER JOIN
            payments
            ON 
                transactions.Id = payments.TransactionId
            INNER JOIN
            properties
            ON 
                transactions.PropertyId = properties.Id
            INNER JOIN
            propertytypes
            ON 
                properties.PropertyTypeId = propertytypes.Id
        WHERE properties.`Name` != 'Test Property' and FirstName is not NULL
        ");

        foreach ($payments as $payment) {

            Payment::updateOrCreate([
                'reservation_id' => $reservation->id,
                'buyer_id' => $reservation->buyer_id,
                'paid_at' => now(),
                'ar_number' => random_int(1000, 5000),
                'amount' => random_int(20000, 40000),
                'type_of_payment' => fake()->randomElement(['Reservation', 'Amortization']),
                'mode_of_payment' => fake()->randomElement(['Cash', 'Cheque', 'Gcash', 'Maya', 'Paypal']),
                'image' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
            ]);
        }
    }
}
