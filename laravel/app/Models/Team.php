<?php

// app/Models/Team.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'tag',
        'description',
        'logo',
        'captain_id',
        'max_members',
        'win_rate',
        'total_matches',
        'is_active',
    ];

    protected $casts = [
        'win_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($team) {
            if (empty($team->slug)) {
                $team->slug = Str::slug($team->name);
            }
        });
    }

    // Relationships
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members')
                    ->withPivot('role', 'joined_at', 'is_active')
                    ->withTimestamps();
    }

    public function tournamentRegistrations()
    {
        return $this->hasMany(TournamentRegistration::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(Matches::class, 'team1_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Matches::class, 'team2_id');
    }

    public function wonMatches()
    {
        return $this->hasMany(Matches::class, 'winner_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper Methods
    public function allMatches()
    {
        return Matches::where(function($query) {
            $query->where('team1_id', $this->id)
                  ->orWhere('team2_id', $this->id);
        });
    }

    public function updateWinRate()
    {
        $totalMatches = $this->allMatches()->where('status', 'completed')->count();
        $wins = $this->wonMatches()->where('status', 'completed')->count();
        
        $this->total_matches = $totalMatches;
        $this->win_rate = $totalMatches > 0 ? ($wins / $totalMatches) * 100 : 0;
        $this->save();
    }
}
