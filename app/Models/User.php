<?php

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
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========== RELATIONS ==========

    /**
     * User a plusieurs Tickets
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class); // RELATION User-Ticket 1-N
    }

    /**
     * ⭐ NEW: User a plusieurs Notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ========== MÉTHODES UTILES ==========

    /**
     * Créer une notification pour cet utilisateur
     */
    public function notifyTicketCreated(Ticket $ticket)
    {
        $this->notifications()->create([
            'ticket_id' => $ticket->id,
            'type' => 'ticket_created',
            'title' => 'Nouveau ticket créé ✅',
            'message' => "Votre ticket pour {$ticket->hosting->nom} a été créé avec succès!",
            'is_read' => false,
        ]);
    }

    /**
     * Compter les notifications non-lues
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->unread()->count();
    }

    /**
     * Récupérer les 5 dernières notifications
     */
    public function recentNotifications($limit = 5)
    {
        return $this->notifications()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}