<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hosting extends Model // il contient les offres d'hébergement et CRUD 
{
    use HasFactory; // 
    protected $table = 'hostings';
    protected $fillable = [ // selection des champs qui peuvent etre remplis directement
        'nom',
        'prix',
        'duree',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class); // un hosting  peut etre relie avc plusieurs tickets
    }
}