<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diplome;
use Illuminate\Http\Request;

class DiplomeController extends Controller
{
    public function index()
    {
        // Charge la relation filiere pour que le front puisse afficher d.filiere.nom
        return response()->json(Diplome::with('filiere')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $diplome = Diplome::create([
            'nom'        => $request->nom,
            'filiere_id' => $request->filiere_id,
        ]);

        return response()->json($diplome->load('filiere'), 201);
    }

    public function show(Diplome $diplome)
    {
        return response()->json($diplome->load('filiere'));
    }

    public function update(Request $request, Diplome $diplome)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
        ]);

        $diplome->update($request->only(['nom', 'filiere_id']));

        return response()->json($diplome->load('filiere'));
    }

    public function destroy(Diplome $diplome)
    {
        $diplome->delete();
        return response()->json(null, 204);
    }
}
