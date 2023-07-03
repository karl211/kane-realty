<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Network;
use App\Models\Profile;
use App\Models\Attorney;
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
        $buyer = User::with('coBorrowers')->whereHas('roles', function($q) {
                $q->where('name', 'buyer');
            })
            ->inRandomOrder()
            ->first();
        $attorny = Attorney::inRandomOrder()->first();
        $network = Network::inRandomOrder()->first();
        $manager = User::whereHas('roles', function($q) {
                $q->where('name', 'sales manager');
            })
            ->inRandomOrder()
            ->first();
        $agent = User::whereHas('roles', function($q) {
                $q->where('name', 'sales agent');
            })
            ->inRandomOrder()
            ->first();

        if ($buyer && $manager && $attorny) {
            return [
                'buyer_id' => $buyer->id,
                'co_borrower_id' => $buyer->coBorrowers()->first()->id,
                'attorney_id' => $attorny->id,
                'property_id' => random_int(1, 500),
                'network_id' => $network->id,
                'sales_manager_id' => $manager->id,
                'sales_agent_id' => $agent->id,
                'contract_price' => random_int(100000, 500000),
                'monthly_amortization' => random_int(20000, 40000),
                'term' => fake()->randomElement([5, 10, 15, 20, 25, 30]),
                'transaction_at' => now(),
            ];
        }
        
    }
}
