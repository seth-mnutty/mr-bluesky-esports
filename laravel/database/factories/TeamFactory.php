<?php

// database/factories/TeamFactory.php
namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        $tag = strtoupper(substr(str_replace(' ', '', $name), 0, 3));
        
        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'tag' => $tag . fake()->unique()->numberBetween(1, 999),
            'description' => fake()->paragraph(),
            'logo' => 'teams/logos/default.png',
            'captain_id' => User::where('role', 'player')->inRandomOrder()->first()->id ?? User::factory()->player(),
            'max_members' => 5,
            'win_rate' => 0.00,
            'total_matches' => 0,
            'is_active' => true,
        ];
    }
}
