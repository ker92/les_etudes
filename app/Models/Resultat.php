<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'diplome_id',
        'annee_id',
        'statut_resultat',
        'est_valide',
        'est_publie',
        'date_validation',
        'date_publication'
    ];


    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }

    public function annee()
    {
        return $this->belongsTo(Annee::class);
    }
}
