<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EtudiantController extends Controller
{
    public function index()
    {
        return response()->json(
            Etudiant::with(['filiere', 'diplome'])->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'diplome_id' => 'required|exists:diplomes,id',
        ]);

        $etudiant = Etudiant::create([
            'nom'               => $request->nom,
            'prenom'            => $request->prenom,
            'filiere_id'        => $request->filiere_id,
            'diplome_id'        => $request->diplome_id,
            'identifiant_unique' => strtoupper(Str::random(8)),
        ]);

        return response()->json($etudiant->load(['filiere', 'diplome']), 201);
    }

    public function show(Etudiant $etudiant)
    {
        return response()->json($etudiant->load(['filiere', 'diplome']));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'diplome_id' => 'required|exists:diplomes,id',
        ]);

        $etudiant->update($request->only(['nom', 'prenom', 'filiere_id', 'diplome_id']));

        return response()->json($etudiant->load(['filiere', 'diplome']));
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return response()->json(null, 204);
    }
}
