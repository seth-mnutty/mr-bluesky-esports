<?php

// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // IMPORTANT: Run in this exact order to avoid foreign key errors
        $this->call([
            UserSeeder::class,          // 1. Create users first
            GameSeeder::class,           // 2. Create games (needs users)
            TeamSeeder::class,           // 3. Create teams (needs users)
            TournamentSeeder::class, // 4. Create tournaments (needs games and users)
            MatchesSeeder::class, // 5. Create matches (needs tournaments and teams)
            RatingAndReviewSeeder::class,
            // 6. Create ratings/reviews (needs everything)
        ]);
    }
}