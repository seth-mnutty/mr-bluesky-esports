<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Game;
use App\Models\TournamentRegistration;
use App\Models\Matches;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentFixtureTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_generate_fixtures()
    {
        $organizer = User::factory()->create();
        $game = Game::factory()->create();
        
        $tournament = Tournament::factory()->create([
            'organizer_id' => $organizer->id,
            'game_id' => $game->id,
            'format' => 'single_elimination',
            'max_teams' => 4,
            'tournament_start' => now()->addDays(1),
        ]);

        // Create 4 teams and register them
        $teams = Team::factory()->count(4)->create();
        foreach ($teams as $team) {
            TournamentRegistration::create([
                'tournament_id' => $tournament->id,
                'team_id' => $team->id,
                'status' => 'approved',
                'registered_at' => now(),
            ]);
        }

        $response = $this->actingAs($organizer)
            ->post(route('tournaments.generate-fixtures', $tournament->slug));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Check if matches were created
        $this->assertDatabaseCount('matches', 2); // 4 teams single elimination = 2 matches in round 1
    }

    public function test_leaderboard_updates_on_match_completion()
    {
        $organizer = User::factory()->create();
        $game = Game::factory()->create();
        
        $tournament = Tournament::factory()->create([
            'organizer_id' => $organizer->id,
            'game_id' => $game->id,
        ]);

        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();

        $reg1 = TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'team_id' => $team1->id,
            'status' => 'approved',
            'registered_at' => now(),
        ]);

        $reg2 = TournamentRegistration::create([
            'tournament_id' => $tournament->id,
            'team_id' => $team2->id,
            'status' => 'approved',
            'registered_at' => now(),
        ]);

        $match = Matches::create([
            'tournament_id' => $tournament->id,
            'team1_id' => $team1->id,
            'team2_id' => $team2->id,
            'round' => 1,
            'match_number' => 1,
            'scheduled_at' => now(),
            'status' => 'scheduled',
        ]);

        // Update score to complete match (Team 1 wins)
        $response = $this->actingAs($organizer)
            ->put(route('matches.update-score', $match->id), [
                'team1_score' => 2,
                'team2_score' => 1,
                'status' => 'completed',
            ]);

        $response->assertRedirect();

        // Check leaderboard stats
        $this->assertDatabaseHas('tournament_registration', [
            'team_id' => $team1->id,
            'points' => 3,
            'wins' => 1,
            'matches_played' => 1,
        ]);

        $this->assertDatabaseHas('tournament_registration', [
            'team_id' => $team2->id,
            'points' => 0,
            'losses' => 1,
            'matches_played' => 1,
        ]);
    }
}
