<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'identifiant_unique',
        'diplome_id',
        'annee_id'
    ];

    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }

    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }
}
