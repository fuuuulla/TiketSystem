<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'type',
        'title',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    // ========== RELATIONS ==========

    /**
     * Notification appartient à un User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Notification concerne un Ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // ========== SCOPES (Requêtes réutilisables) ==========

    /**
     * Scope: Notifications non lues
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: Notifications d'un utilisateur
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ========== MÉTHODES UTILES ==========

    /**
     * Marquer la notification comme lue
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Marquer comme non-lue
     */
    public function markAsUnread()
    {
        $this->update(['is_read' => false]);
    }
}