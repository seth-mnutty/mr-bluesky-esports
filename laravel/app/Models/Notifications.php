<?php

// app/Models/Notification.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Helper Methods
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}(Matches::class);
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
