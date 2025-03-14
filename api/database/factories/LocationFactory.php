<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'branch_id' => 1,
            'location' => fake()->name(),
            'description' => fake()->text(),
            'photo' => fake()->imageUrl(400, 300, 'cats'),
        ];
    }
}
