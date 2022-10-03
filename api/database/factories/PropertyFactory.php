<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'location_id' => random_int(1, 8),
            'block' => random_int(1, 500),
            'lot' => random_int(1, 500),
            'phase' => random_int(1, 100),
            'lot_size' => random_int(100, 500) . ' sqm',
            'floor_area' => random_int(100, 500) . ' sqm',
            'contract_price' => random_int(100000, 500000),
            'default_monthly_amortization' => random_int(20000, 40000),
            'term' => fake()->randomElement([5, 10, 15, 20, 25, 30]),
            'model' => fake()->firstName(),
            'photo' => 'https://loremflickr.com/640/480/business?'. random_int(1, 5000),
            'description' => fake()->realText(100, 2),
            'status' => fake()->randomElement(['available', 'reserved', 'assumed', 'occupied']),
        ];
    }
}
