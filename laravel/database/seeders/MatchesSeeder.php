<?php

// database/seeders/MatchSeeder.php
namespace Database\Seeders;

use App\Models\Matches;
use App\Models\PlayerPerformances;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class MatchesSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating matches...');

        $ongoingTournaments = Tournament::where('status', 'ongoing')->get();

        foreach ($ongoingTournaments as $tournament) {
            $teams = $tournament->registrations()
                ->where('status', 'approved')
                ->with('team')
                ->get()
                ->pluck('team');

            if ($teams->count() < 2) {
                $this->command->warn('Tournament ' . $tournament->name . ' has less than 2 teams');
                continue;
            }

            // Create matches for first round
            $matchNumber = 1;
            $teamsArray = $teams->toArray();
            
            for ($i = 0; $i < count($teamsArray) - 1; $i += 2) {
                if (!isset($teamsArray[$i + 1])) break;

                $match = Matches::create([
                    'tournament_id' => $tournament->id,
                    'team1_id' => $teamsArray[$i]['id'],
                    'team2_id' => $teamsArray[$i + 1]['id'],
                    'round' => 1,
                    'match_number' => $matchNumber++,
                    'scheduled_at' => now()->addDays(rand(1, 7)),
                    'status' => 'scheduled',
                    'stream_url' => 'https://twitch.tv/esports',
                    'notes' => null,
                ]);

                // 40% of matches are completed
                if (rand(0, 100) < 40) {
                    $team1Score = rand(0, 3);
                    $team2Score = rand(0, 3);
                    
                    // Ensure there's a winner
                    while ($team1Score === $team2Score) {
                        $team2Score = rand(0, 3);
                    }
                    
                    $match->update([
                        'started_at' => now()->subDays(rand(1, 10))->subHours(2),
                        'completed_at' => now()->subDays(rand(1, 10)),
                        'team1_score' => $team1Score,
                        'team2_score' => $team2Score,
                        'winner_id' => $team1Score > $team2Score ? $teamsArray[$i]['id'] : $teamsArray[$i + 1]['id'],
                        'status' => 'completed',
                    ]);

                    // Add player performances for completed matches
                    $this->createPlayerPerformances($match, $teams[$i], $teams[$i + 1]);
                }
            }
        }

        $this->command->info('✓ Matches created: ' . Matches::count() . ' total');
    }

    private function createPlayerPerformances($match, $team1, $team2)
    {
        // Team 1 performances
        $team1Members = $team1->members()->wherePivot('is_active', true)->take(5)->get();
        foreach ($team1Members as $player) {
            $kills = rand(0, 25);
            $deaths = rand(1, 15);
            $assists = rand(0, 20);
            
            PlayerPerformances::create([
                'match_id' => $match->id,
                'user_id' => $player->id,
                'team_id' => $team1->id,
                'kills' => $kills,
                'deaths' => $deaths,
                'assists' => $assists,
                'kda_ratio' => round(($kills + $assists) / max($deaths, 1), 2),
                'damage_dealt' => rand(10000, 50000),
                'healing_done' => rand(0, 10000),
                'objectives_captured' => rand(0, 8),
                'accuracy' => rand(45, 95) + (rand(0, 99) / 100),
                'additional_stats' => json_encode(['headshots' => rand(5, 20)]),
            ]);
        }

        // Team 2 performances
        $team2Members = $team2->members()->wherePivot('is_active', true)->take(5)->get();
        foreach ($team2Members as $player) {
            $kills = rand(0, 25);
            $deaths = rand(1, 15);
            $assists = rand(0, 20);
            
            PlayerPerformances::create([
                'match_id' => $match->id,
                'user_id' => $player->id,
                'team_id' => $team2->id,
                'kills' => $kills,
                'deaths' => $deaths,
                'assists' => $assists,
                'kda_ratio' => round(($kills + $assists) / max($deaths, 1), 2),
                'damage_dealt' => rand(10000, 50000),
                'healing_done' => rand(0, 10000),
                'objectives_captured' => rand(0, 8),
                'accuracy' => rand(45, 95) + (rand(0, 99) / 100),
                'additional_stats' => json_encode(['headshots' => rand(5, 20)]),
            ]);
        }
    }
}