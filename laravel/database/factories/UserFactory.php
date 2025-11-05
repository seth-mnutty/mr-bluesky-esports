<?php

// database/factories/UserFactory.php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'player',
            'phone' => fake()->phoneNumber(),
            'bio' => fake()->paragraph(),
            'avatar' => 'avatars/default.png',
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function organizer()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'organizer',
        ]);
    }

    public function player()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'player',
        ]);
    }

    public function spectator()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'spectator',
        ]);
    }
}
