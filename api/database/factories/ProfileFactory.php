<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $table->string('first_name');
        //     $table->string('last_name');
        //     $table->string('middle_name')->nullable();
        //     $table->string('suffix')->nullable();
        //     $table->string('gender')->nullable();
        //     $table->string('tin')->nullable();
        //     $table->timestamp('date_of_birth')->nullable();
        //     $table->string('civil_status')->nullable();
        //     $table->string('religion')->nullable();
        //     $table->string('contact_number')->nullable();
        //     $table->string('zip_code')->nullable();
        //     $table->text('address')->nullable();

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'profile_type' => fake()->randomElement(['client', 'network', 'co_borrower', 'attorney', 'cashier', 'sales manager', 'sales agent']),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'middle_name' => fake()->lastName(),
            'suffix' => fake()->suffix(),
            'gender' => fake()->randomElement(['male', 'female']),
            'tin' => fake()->ean8(),
            'date_of_birth' => fake()->dateTime($max = 'now', $timezone = null),
            'civil_status' => fake()->randomElement(['single', 'married']),
            'contact_number' => fake()->ean8(),
            'zip_code' => fake()->ean8(),
            'address' => fake()->address(),
        ];
    }
}
