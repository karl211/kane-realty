<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // client_id
        // co_borrower_id
        // attorney_id
        // property_id
        // network_id
        // sales_manager_id
        // sales_agent_id
        // contract_price
        // monthly_amortization
        // terms
        // transaction_at
        $clients = User::whereHas('profile', function($query) {
                $query->where('profile_type', 'client');
            })
            ->pluck('id')
            ->toArray();
        // $clients = User::where('profile_type', 'client')->pluck('id')->toArray();
        $co_borrowers = Profile::where('profile_type', 'co_borrower')->pluck('id')->toArray();
        $attornies = Profile::where('profile_type', 'attorney')->pluck('id')->toArray();
        
        $networks = User::whereHas('profile', function($query) {
            $query->where('profile_type', 'network');
        })
        ->pluck('id')
        ->toArray();

        $managers = User::whereHas('profile', function($query) {
            $query->where('profile_type', 'sales manager');
        })
        ->pluck('id')
        ->toArray();

        $agents = User::whereHas('profile', function($query) {
            $query->where('profile_type', 'sales agent');
        })
        ->pluck('id')
        ->toArray();

        // $networks = Profile::where('profile_type', 'network')->pluck('id')->toArray();
        // $managers = Profile::where('profile_type', 'sales manager')->pluck('id')->toArray();
        // $agents = Profile::where('profile_type', 'sales agent')->pluck('id')->toArray();
        return [
            'buyer_id' => fake()->randomElement($clients),
            'co_borrower_id' => fake()->randomElement($co_borrowers),
            'attorney_id' => fake()->randomElement($attornies),
            'property_id' => random_int(1, 500),
            'network_id' => fake()->randomElement($networks),
            'sales_manager_id' => fake()->randomElement($managers),
            'sales_agent_id' => fake()->randomElement($agents),
            'contract_price' => random_int(100000, 500000),
            'monthly_amortization' => random_int(20000, 40000),
            'terms' => fake()->randomElement([5, 10, 15, 20, 25, 30]),
            'transaction_at' => now(),
        ];
    }
}
