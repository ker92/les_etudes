<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    protected $fillable = ['annee'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
