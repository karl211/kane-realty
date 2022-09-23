<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_contains_non_empty_table()
    {
        $role = Role::create([
            'name' => 'admin'
        ]);

        $user = User::create([
            'role_id' => $role->id,
            'name' => 'Admin1',
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('secret123'), // password
            'remember_token' => Str::random(10),
        ]);
        
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Admin1');
        $response->assertViewHas('users', function ($collection) use ($user) {
            return $collection->contains($user);
        });
    }
}
