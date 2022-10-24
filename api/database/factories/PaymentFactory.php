<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $reservation = Reservation::inRandomOrder()->first();

        return [
            'reservation_id' => $reservation->id,
            'buyer_id' => $reservation->buyer_id,
            'paid_at' => now(),
            'ar_number' => random_int(1000, 5000),
            'amount' => random_int(20000, 40000),
            'type_of_payment' => fake()->randomElement(['Reservation', 'Amortization']),
            'mode_of_payment' => fake()->randomElement(['Cash', 'Cheque', 'Gcash', 'Maya', 'Paypal']),
            'image' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
        ];
    }
}
