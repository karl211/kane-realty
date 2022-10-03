<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuyerCoBorrower>
 */
class BuyerCoBorrowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'buyer_id' => User::with('coBorrower')->where('role_id', 5)->inRandomOrder()->first()->id,
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'middle_name' => fake()->name(),
            'suffix' => fake()->name(),
            'gender' => fake()->randomElement(['male', 'female']),
            'tin' => fake()->ean8(),
            'date_of_birth' => fake()->dateTime($max = 'now', $timezone = null),
            'contact_number' => fake()->ean8(),
        ];
    }
}
