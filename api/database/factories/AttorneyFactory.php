<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attorney>
 */
class AttorneyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
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
