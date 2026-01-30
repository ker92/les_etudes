<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    use HasFactory;

    protected $fillable = ['annee'];

    // Une année peut avoir plusieurs étudiants
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    // Une année peut avoir plusieurs résultats
    public function resultats()
    {
        return $this->hasMany(Resultat::class);
    }
}
