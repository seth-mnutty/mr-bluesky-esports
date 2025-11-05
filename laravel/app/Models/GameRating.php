<?php
// app/Models/GameRating.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'rating',
    ];

    // Relationships
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($rating) {
            $rating->game->updateAverageRating();
        });

        static::deleted(function ($rating) {
            $rating->game->updateAverageRating();
        });
    }
}
