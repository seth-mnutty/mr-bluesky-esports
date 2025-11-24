<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

class UpdateGameImages extends Command
{
    protected $signature = 'games:update-images';
    protected $description = 'Update game cover images with URLs';

    public function handle()
    {
        $this->info('Updating game cover images...');

        // Using reliable image URLs - these are placeholder images that will definitely work
        // You can replace these with actual game cover URLs later
        $gameImages = [
            'league-of-legends' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=600&h=800&fit=crop',
            'counter-strike-global-offensive' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=600&h=800&fit=crop',
            'dota-2' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=600&h=800&fit=crop',
            'valorant' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=800&fit=crop',
            'fc-26' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=600&h=800&fit=crop', // FC 26 cover
            'fortnite' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=800&fit=crop', // Fortnite cover
        ];

        // Alternative: Use placeholder images from a reliable CDN
        $fallbackImages = [
            'league-of-legends' => 'https://via.placeholder.com/600x800/FF6B6B/FFFFFF?text=League+of+Legends',
            'counter-strike-global-offensive' => 'https://via.placeholder.com/600x800/4ECDC4/FFFFFF?text=CS%3AGO',
            'dota-2' => 'https://via.placeholder.com/600x800/45B7D1/FFFFFF?text=Dota+2',
            'valorant' => 'https://via.placeholder.com/600x800/FFA07A/FFFFFF?text=Valorant',
            'fc-26' => 'https://via.placeholder.com/600x800/98D8C8/FFFFFF?text=FC+26',
            'fortnite' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=800&fit=crop',
        ];

        $updated = 0;
        foreach ($gameImages as $slug => $imageUrl) {
            $game = Game::where('slug', $slug)->first();
            if ($game) {
                $game->update(['cover_image' => $imageUrl]);
                $updated++;
                $this->info("✓ Updated {$game->title} with cover image");
            } else {
                $this->warn("Game with slug '{$slug}' not found");
            }
        }

        // Also update any games that don't have images yet
        $gamesWithoutImages = Game::whereNull('cover_image')
            ->orWhere('cover_image', '')
            ->orWhere('cover_image', 'games/covers/default.jpg')
            ->get();

        foreach ($gamesWithoutImages as $game) {
            // Generate a placeholder based on the game title
            $placeholderUrl = 'https://via.placeholder.com/600x800/667EEA/FFFFFF?text=' . urlencode(substr($game->title, 0, 20));
            $game->update(['cover_image' => $placeholderUrl]);
            $this->info("✓ Added placeholder image for {$game->title}");
            $updated++;
        }

        $this->info("\n✓ Successfully updated {$updated} games with cover images!");
        return 0;
    }
}

