<?php

// database/seeders/TournamentSeeder.php
namespace Database\Seeders;

use App\Models\Tournament;
use App\Models\TournamentRegistration;
use App\Models\Game;
use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TournamentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating tournaments...');

        $games = Game::all();
        $organizers = User::where('role', 'organizer')->get();
        $teams = Team::all();

        if ($games->isEmpty() || $organizers->isEmpty() || $teams->isEmpty()) {
            $this->command->error('Missing required data (games, organizers, or teams)!');
            return;
        }

        // Create 3 upcoming tournaments
        for ($i = 1; $i <= 3; $i++) {
            $regStart = now()->addDays(5 + $i);
            $regEnd = $regStart->copy()->addDays(14);
            $tourneyStart = $regEnd->copy()->addDays(7);

            $name = $games->random()->title . ' Championship ' . $i;

            $tournament = Tournament::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Join us for an exciting tournament featuring the best teams!',
                'game_id' => $games->random()->id,
                'organizer_id' => $organizers->random()->id,
                'format' => 'single_elimination',
                'max_teams' => 16,
                'team_size' => 5,
                'prize_pool' => rand(10000, 50000),
                'banner_image' => 'tournaments/banners/default.jpg',
                'registration_start' => $regStart,
                'registration_end' => $regEnd,
                'tournament_start' => $tourneyStart,
                'tournament_end' => null,
                'status' => 'registration_open',
                'rules' => ['Check-in required 30 minutes before match', 'Standard rules apply'],
            ]);

            // Register some teams
            $registeredTeams = $teams->random(min(8, $teams->count()));
            foreach ($registeredTeams as $team) {
                TournamentRegistration::create([
                    'tournament_id' => $tournament->id,
                    'team_id' => $team->id,
                    'status' => rand(0, 3) ? 'approved' : 'pending',
                    'registered_at' => now()->subDays(rand(1, 10)),
                    'approved_at' => rand(0, 3) ? now()->subDays(rand(1, 5)) : null,
                ]);
            }
        }

        // Create 2 ongoing tournaments
        for ($i = 1; $i <= 2; $i++) {
            $name = $games->random()->title . ' Season ' . $i;

            $tournament = Tournament::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Ongoing competitive tournament with exciting matches!',
                'game_id' => $games->random()->id,
                'organizer_id' => $organizers->random()->id,
                'format' => 'double_elimination',
                'max_teams' => 16,
                'team_size' => 5,
                'prize_pool' => rand(20000, 100000),
                'banner_image' => 'tournaments/banners/default.jpg',
                'registration_start' => now()->subDays(45),
                'registration_end' => now()->subDays(30),
                'tournament_start' => now()->subDays(15),
                'tournament_end' => null,
                'status' => 'ongoing',
                'rules' => ['Check-in required', 'Fair play policy enforced'],
            ]);

            // Register and approve all teams
            $registeredTeams = $teams->random(min(16, $teams->count()));
            foreach ($registeredTeams as $team) {
                TournamentRegistration::create([
                    'tournament_id' => $tournament->id,
                    'team_id' => $team->id,
                    'status' => 'approved',
                    'registered_at' => now()->subDays(rand(35, 45)),
                    'approved_at' => now()->subDays(rand(25, 35)),
                ]);
            }
        }

        $this->command->info('✓ Tournaments created: ' . Tournament::count() . ' total');
    }
}
