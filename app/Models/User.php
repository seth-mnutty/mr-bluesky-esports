<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'phone',
        'bio',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_members')
                    ->withPivot('role', 'joined_at', 'is_active')
                    ->withTimestamps();
    }

    public function captainedTeams()
    {
        return $this->hasMany(Team::class, 'captain_id');
    }

    public function organizedTournaments()
    {
        return $this->hasMany(Tournament::class, 'organizer_id');
    }

    // Add this new relationship method
    public function tournamentRegistrations()
    {
        return $this->hasManyThrough(
            TournamentRegistration::class,
            Team::class,
            'captain_id', // Foreign key on teams table
            'team_id', // Foreign key on tournament_registrations table
            'id', // Local key on users table
            'id' // Local key on teams table
        )->orWhereHas('team.members', function($query) {
            $query->where('users.id', $this->id);
        });
    }

    // Alternative simpler approach - get registrations through teams
    public function getTournamentRegistrationsAttribute()
    {
        $teamIds = $this->teams()->pluck('teams.id')->merge($this->captainedTeams()->pluck('id'));
        return TournamentRegistration::whereIn('team_id', $teamIds)->get();
    }

    public function gameRatings()
    {
        return $this->hasMany(GameRating::class);
    }

    public function gameReviews()
    {
        return $this->hasMany(GameReview::class);
    }

    public function matchReviews()
    {
        return $this->hasMany(MatchReview::class);
    }

    public function playerPerformances()
    {
        return $this->hasMany(PlayerPerformance::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function createdGames()
    {
        return $this->hasMany(Game::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOrganizer()
    {
        return $this->role === 'organizer' || $this->role === 'admin';
    }

    public function isPlayer()
    {
        return $this->role === 'player';
    }
}