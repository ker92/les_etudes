<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diplome;
use Illuminate\Http\Request;

class DiplomeController extends Controller
{
    public function index()
    {
        return response()->json(Diplome::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $diplome = Diplome::create([
            'nom' => $request->nom,
            'filiere_id' => $request->filiere_id,
        ]);

        return response()->json($diplome, 201);
    }
}
