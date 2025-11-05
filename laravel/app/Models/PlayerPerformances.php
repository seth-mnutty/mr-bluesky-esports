<?php
// app/Models/PlayerPerformance.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'user_id',
        'team_id',
        'kills',
        'deaths',
        'assists',
        'kda_ratio',
        'damage_dealt',
        'healing_done',
        'objectives_captured',
        'accuracy',
        'additional_stats',
    ];

    protected $casts = [
        'kda_ratio' => 'decimal:2',
        'accuracy' => 'decimal:2',
        'additional_stats' => 'array',
    ];

    // Relationships
    public function match()
    {
        return $this->belongsTo(Matches::class);
    }

    public function player()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Helper Methods
    public function calculateKDA()
    {
        if ($this->deaths == 0) {
            $this->kda_ratio = $this->kills + $this->assists;
        } else {
            $this->kda_ratio = ($this->kills + $this->assists) / $this->deaths;
        }
        $this->save();
    }
}
