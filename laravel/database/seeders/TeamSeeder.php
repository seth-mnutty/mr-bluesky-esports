<?php

// database/seeders/TeamSeeder.php
namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating teams...');

        $players = User::where('role', 'player')->get();

        if ($players->count() < 5) {
            $this->command->error('Not enough players to create teams!');
            return;
        }

        // Create 20 teams
        $teamNames = [
            'Thunder Hawks', 'Phoenix Rising', 'Cyber Wolves', 'Digital Dragons',
            'Elite Squad', 'Victory Legion', 'Storm Breakers', 'Night Raiders',
            'Iron Titans', 'Shadow Ninjas', 'Alpha Warriors', 'Blazing Stars',
            'Quantum Force', 'Mystic Knights', 'Crimson Eagles', 'Azure Legends',
            'Omega Strike', 'Velocity Gaming', 'Nexus Team', 'Fusion Esports'
        ];

        $usedPlayers = collect();

        foreach ($teamNames as $index => $teamName) {
            // Select a captain who hasn't been used
            $availablePlayers = $players->whereNotIn('id', $usedPlayers);
            
            if ($availablePlayers->count() < 5) {
                $this->command->warn('Not enough players remaining for more teams');
                break;
            }

            $captain = $availablePlayers->random();
            $usedPlayers->push($captain->id);

            $tag = strtoupper(substr(str_replace(' ', '', $teamName), 0, 3));

            $team = Team::create([
                'name' => $teamName,
                'slug' => Str::slug($teamName),
                'tag' => $tag . ($index + 1),
                'description' => "Professional esports team competing in multiple tournaments",
                'logo' => 'teams/logos/default.png',
                'captain_id' => $captain->id,
                'max_members' => 5,
                'win_rate' => 0,
                'total_matches' => 0,
                'is_active' => true,
            ]);

            // Add captain as member
            $team->members()->attach($captain->id, [
                'role' => 'captain',
                'joined_at' => now()->subMonths(rand(1, 12)),
                'is_active' => true,
            ]);

            // Add 4 more players
            $teamMembers = $availablePlayers->where('id', '!=', $captain->id)->random(min(4, $availablePlayers->count() - 1));
            
            foreach ($teamMembers as $member) {
                $usedPlayers->push($member->id);
                $team->members()->attach($member->id, [
                    'role' => rand(0, 1) ? 'player' : 'substitute',
                    'joined_at' => now()->subMonths(rand(1, 6)),
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('✓ Teams created: ' . Team::count() . ' total');
    }
}