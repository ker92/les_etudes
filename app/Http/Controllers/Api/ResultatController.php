<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resultat;
use Illuminate\Http\Request;

class ResultatController extends Controller
{
    public function index()
    {
        return response()->json(Resultat::with(['etudiant', 'diplome', 'annee'])->get());
    }

    public function store(Request $request)
    {
        $resultat = Resultat::create($request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'diplome_id' => 'required|exists:diplomes,id',
            'annee_id' => 'required|exists:annees,id',
            'statut_resultat' => 'nullable|in:admis,refuse,rattrapage',
            'est_valide' => 'boolean',
            'est_publie' => 'boolean',
            'date_validation' => 'nullable|date',
            'date_publication' => 'nullable|date',
        ]));

        return response()->json($resultat, 201);
    }

    public function show(Resultat $resultat)
    {
        return response()->json($resultat->load(['etudiant', 'diplome', 'annee']));
    }

    public function update(Request $request, Resultat $resultat)
    {
        $resultat->update($request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'diplome_id' => 'required|exists:diplomes,id',
            'annee_id' => 'required|exists:annees,id',
            'statut_resultat' => 'nullable|in:admis,refuse,rattrapage',
            'est_valide' => 'boolean',
            'est_publie' => 'boolean',
            'date_validation' => 'nullable|date',
            'date_publication' => 'nullable|date',
        ]));

        return response()->json($resultat);
    }

    public function destroy(Resultat $resultat)
    {
        $resultat->delete();
        return response()->json(null, 204);
    }
}
