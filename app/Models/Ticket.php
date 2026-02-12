<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = [
        'user_id',
        'hosting_id',
        'nom_complet',
        'telephone',
        'adresse',
        'societe',
        'statut',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function hosting()
    {
        return $this->belongsTo(Hosting::class); // un ticket peut  se vendre a un seul utilisateur
    }
}