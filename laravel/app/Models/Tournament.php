<?php
// app/Models/Tournament.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'game_id',
        'organizer_id',
        'format',
        'max_teams',
        'team_size',
        'prize_pool',
        'banner_image',
        'registration_start',
        'registration_end',
        'tournament_start',
        'tournament_end',
        'status',
        'rules',
    ];

    protected $casts = [
        'registration_start' => 'date',
        'registration_end' => 'date',
        'tournament_start' => 'date',
        'tournament_end' => 'date',
        'prize_pool' => 'decimal:2',
        'rules' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tournament) {
            if (empty($tournament->slug)) {
                $tournament->slug = Str::slug($tournament->name);
            }
        });
    }

    // Relationships
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(TournamentRegistration::class);
    }

    public function matches()
    {
        return $this->hasMany(Matches::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('tournament_start', '>', now())
                     ->orderBy('tournament_start', 'asc');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helper Methods
    public function isRegistrationOpen()
    {
        return $this->status === 'registration_open' 
               && now()->between($this->registration_start, $this->registration_end);
    }

    public function canRegister()
    {
        return $this->isRegistrationOpen() 
               && $this->registrations()->where('status', 'approved')->count() < $this->max_teams;
    }
}
