<?php

// database/seeders/GameSeeder.php
namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating games...');

        $admin = User::where('role', 'admin')->first();
        
        // Popular esports games with proper data and cover images
        $games = [
            [
                'title' => 'League of Legends',
                'slug' => 'league-of-legends',
                'description' => 'A team-based strategy game where two teams of five powerful champions face off to destroy the other\'s base.',
                'genre' => 'MOBA',
                'publisher' => 'Riot Games',
                'platform' => 'PC',
                'min_players' => 2,
                'max_players' => 10,
                'release_date' => '2009-10-27',
                'average_rating' => 4.50,
                'total_reviews' => 0,
                'cover_image' => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co49x5.png', // League of Legends cover
            ],
            [
                'title' => 'Counter-Strike Global Offensive',
                'slug' => 'counter-strike-global-offensive',
                'description' => 'CS:GO expands upon the team-based action gameplay featuring new maps, characters, and weapons.',
                'genre' => 'FPS',
                'publisher' => 'Valve Corporation',
                'platform' => 'PC',
                'min_players' => 2,
                'max_players' => 10,
                'release_date' => '2012-08-21',
                'average_rating' => 4.40,
                'total_reviews' => 0,
                'cover_image' => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1r76.png', // CS:GO cover
            ],
            [
                'title' => 'Dota 2',
                'slug' => 'dota-2',
                'description' => 'Every day, millions of players worldwide enter battle as one of over a hundred Dota heroes.',
                'genre' => 'MOBA',
                'publisher' => 'Valve Corporation',
                'platform' => 'PC',
                'min_players' => 2,
                'max_players' => 10,
                'release_date' => '2013-07-09',
                'average_rating' => 4.30,
                'total_reviews' => 0,
                'cover_image' => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co45wx.png', // Dota 2 cover
            ],
            [
                'title' => 'Valorant',
                'slug' => 'valorant',
                'description' => 'A 5v5 character-based tactical FPS where precise gunplay meets unique agent abilities.',
                'genre' => 'FPS',
                'publisher' => 'Riot Games',
                'platform' => 'PC',
                'min_players' => 2,
                'max_players' => 10,
                'release_date' => '2020-06-02',
                'average_rating' => 4.60,
                'total_reviews' => 0,
                'cover_image' => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2r7j.png', // Valorant cover
            ],
            [
                'title' => 'FC 26',
                'slug' => 'fc-26',
                'description' => 'Experience the world\'s game with over 19,000 players and 700+ teams in the latest EA Sports FC installment.',
                'genre' => 'Sports',
                'publisher' => 'EA Sports',
                'platform' => 'Cross-platform',
                'min_players' => 2,
                'max_players' => 22,
                'release_date' => '2025-09-26',
                'average_rating' => 4.20,
                'total_reviews' => 0,
                'cover_image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=600&h=800&fit=crop', // FC 26 cover
            ],
            [
                'title' => 'Fortnite',
                'slug' => 'fortnite',
                'description' => 'Drop into a battle royale with 100 players where you can build and battle your way to victory.',
                'genre' => 'Battle Royale',
                'publisher' => 'Epic Games',
                'platform' => 'Cross-platform',
                'min_players' => 1,
                'max_players' => 100,
                'release_date' => '2017-07-25',
                'average_rating' => 4.10,
                'total_reviews' => 0,
                'cover_image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=800&fit=crop', // Fortnite cover
            ],
        ];

        foreach ($games as $gameData) {
            Game::updateOrCreate(
                ['slug' => $gameData['slug']],
                array_merge($gameData, [
                    'created_by' => $admin->id,
                    'is_active' => true,
                    'cover_image' => $gameData['cover_image'] ?? null,
                ])
            );
        }

        $this->command->info('✓ Games created/updated: ' . Game::count() . ' total');
    }
}
