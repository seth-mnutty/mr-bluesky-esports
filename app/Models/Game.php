<?php
// app/Models/Game.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'genre',
        'publisher',
        'release_date',
        'cover_image',
        'platform',
        'min_players',
        'max_players',
        'average_rating',
        'total_reviews',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'release_date' => 'date',
        'average_rating' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->title);
            }
        });
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function ratings()
    {
        return $this->hasMany(GameRating::class);
    }

    public function reviews()
    {
        return $this->hasMany(GameReview::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('total_reviews', '>=', 10)
            ->orderBy('average_rating', 'desc');
    }

    // Helper Methods
    public function updateAverageRating()
    {
        $this->average_rating = $this->ratings()->avg('rating') ?? 0;
        $this->total_reviews = $this->reviews()->count();
        $this->save();
    }

    /**
     * Get the cover image URL
     * Handles both local storage paths and external URLs
     */
    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return null;
        }

        // Check if it's already a full URL
        if (filter_var($this->cover_image, FILTER_VALIDATE_URL)) {
            return $this->cover_image;
        }

        // Otherwise, it's a local storage path
        return asset('storage/' . $this->cover_image);
    }
}