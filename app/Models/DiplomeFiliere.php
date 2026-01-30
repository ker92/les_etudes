<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DiplomeFiliere extends Pivot
{
    protected $table = 'diplome_filiere';
    protected $fillable = ['diplome_id', 'filiere_id'];
}
