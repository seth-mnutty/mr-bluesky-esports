<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'genre' => $this->faker->word(),
            'publisher' => $this->faker->company(),
            'release_date' => $this->faker->date(),
            'cover_image' => $this->faker->imageUrl(),
            'platform' => $this->faker->randomElement(['PC', 'PS5', 'Xbox', 'Mobile']),
            'min_players' => 1,
            'max_players' => 10,
            'is_active' => true,
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
