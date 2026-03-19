<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    use HasFactory;

    protected $fillable = ['annee'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function resultats()
    {
        return $this->hasMany(Resultat::class);
    }
}
