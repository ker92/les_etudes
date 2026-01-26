<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nom'];

    public function diplomes()
    {
        return $this->belongsToMany(Diplome::class);
    }
}
