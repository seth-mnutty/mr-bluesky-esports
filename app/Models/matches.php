<?php
// app/Models/Matches.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'team1_id',
        'team2_id',
        'round',
        'match_number',
        'scheduled_at',
        'started_at',
        'completed_at',
        'team1_score',
        'team2_score',
        'winner_id',
        'status',
        'stream_url',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    public function winner()
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }

    public function playerPerformances()
    {
        return $this->hasMany(PlayerPerformance::class);
    }

    public function reviews()
    {
        return $this->hasMany(MatchReview::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc');
    }
}