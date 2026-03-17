<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'filiere_id',
        'diplome_id',
        'identifiant_unique',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }

    public function resultats()
    {
        return $this->hasMany(Resultat::class);
    }
}
