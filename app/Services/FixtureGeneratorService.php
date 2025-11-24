<?php

namespace App\Services;

use App\Models\Tournament;
use App\Models\Matches;
use App\Models\Team;
use Carbon\Carbon;

class FixtureGeneratorService
{
    public function generateFixtures(Tournament $tournament)
    {
        $teams = $tournament->registrations()
            ->approved()
            ->with('team')
            ->get()
            ->pluck('team');

        if ($teams->count() < 2) {
            throw new \Exception('Not enough teams to generate fixtures.');
        }

        switch ($tournament->format) {
            case 'single_elimination':
                return $this->generateSingleElimination($tournament, $teams);
            case 'round_robin':
                return $this->generateRoundRobin($tournament, $teams);
            default:
                throw new \Exception('Unsupported tournament format.');
        }
    }

    protected function generateSingleElimination(Tournament $tournament, $teams)
    {
        $teams = $teams->shuffle();
        $count = $teams->count();
        
        // Calculate next power of 2
        $size = pow(2, ceil(log($count, 2)));
        
        // Add byes if necessary
        $byes = $size - $count;
        $teamsArray = $teams->all();
        
        // Create matches for the first round
        $matches = [];
        $matchNumber = 1;
        $startTime = Carbon::parse($tournament->tournament_start)->setTime(10, 0, 0);

        for ($i = 0; $i < $count; $i += 2) {
            if ($i + 1 < $count) {
                $matches[] = Matches::create([
                    'tournament_id' => $tournament->id,
                    'team1_id' => $teamsArray[$i]->id,
                    'team2_id' => $teamsArray[$i+1]->id,
                    'round' => 1,
                    'match_number' => $matchNumber++,
                    'scheduled_at' => $startTime->copy()->addHours($matchNumber),
                    'status' => 'scheduled',
                ]);
            }
        }
        
        return $matches;
    }

    protected function generateRoundRobin(Tournament $tournament, $teams)
    {
        $teams = $teams->shuffle();
        $n = $teams->count();
        
        // If odd number of teams, add a dummy team for bye
        if ($n % 2 != 0) {
            $teams->push(null); 
            $n++;
        }
        
        $teamsArray = $teams->values()->all();
        $matches = [];
        $matchNumber = 1;
        $startTime = Carbon::parse($tournament->tournament_start)->setTime(10, 0, 0);

        // Number of rounds = n - 1
        for ($round = 0; $round < $n - 1; $round++) {
            for ($i = 0; $i < $n / 2; $i++) {
                $team1 = $teamsArray[$i];
                $team2 = $teamsArray[$n - 1 - $i];

                // If either team is null (bye), skip match creation
                if ($team1 && $team2) {
                    $matches[] = Matches::create([
                        'tournament_id' => $tournament->id,
                        'team1_id' => $team1->id,
                        'team2_id' => $team2->id,
                        'round' => $round + 1,
                        'match_number' => $matchNumber++,
                        'scheduled_at' => $startTime->copy()->addDays($round)->addHours($i),
                        'status' => 'scheduled',
                    ]);
                }
            }

            // Rotate teams array for next round: keep first team fixed, rotate others
            $first = array_shift($teamsArray);
            $last = array_pop($teamsArray);
            array_unshift($teamsArray, $last);
            array_unshift($teamsArray, $first);
        }

        return $matches;
    }
}
