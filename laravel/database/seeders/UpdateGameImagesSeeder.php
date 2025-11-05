<?php

// database/seeders/UpdateGameImagesSeeder.php
namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class UpdateGameImagesSeeder extends Seeder
{
    /**
     * Run the database seeds to update game cover images with actual URLs
     */
    public function run(): void
    {
        $this->command->info('Updating game cover images...');

        // Game cover images mapping
        $gameImages = [
            'league-of-legends' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=600&h=800&fit=crop',
            'counter-strike-global-offensive' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=600&h=800&fit=crop',
            'dota-2' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=600&h=800&fit=crop',
            'valorant' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=800&fit=crop',
            'fc-26' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=600&h=800&fit=crop', // FC 26 cover
            'fortnite' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=800&fit=crop', // Fortnite cover
        ];

        $updated = 0;
        foreach ($gameImages as $slug => $imageUrl) {
            $game = Game::where('slug', $slug)->first();
            if ($game) {
                $game->update(['cover_image' => $imageUrl]);
                $updated++;
                $this->command->info("✓ Updated {$game->title} with cover image");
            }
        }

        $this->command->info("✓ Updated {$updated} games with cover images");
    }
}

