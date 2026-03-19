<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resultat;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ResultatController extends Controller
{
    public function index()
    {
        return response()->json(
            Resultat::with(['etudiant', 'diplome', 'annee'])->get()
        );
    }
    public function etudiantsParDiplomeAnnee(Request $request)
    {
        $request->validate([
            'diplome_id' => 'required|exists:diplomes,id',
            'annee_id'   => 'required|exists:annees,id',
        ]);

        $etudiants = Etudiant::where('diplome_id', $request->diplome_id)
            ->with(['filiere', 'diplome', 'resultats' => function ($q) use ($request) {
                $q->where('diplome_id', $request->diplome_id)
                    ->where('annee_id', $request->annee_id);
            }])
            ->get()
            ->map(function ($etudiant) {
                return [
                    'id'                => $etudiant->id,
                    'nom'               => $etudiant->nom,
                    'prenom'            => $etudiant->prenom,
                    'identifiant_unique' => $etudiant->identifiant_unique,
                    'filiere'           => $etudiant->filiere,
                    'diplome'           => $etudiant->diplome,
                    'resultat'          => $etudiant->resultats->first(),
                ];
            });

        return response()->json($etudiants);
    }

    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id'    => 'required|exists:etudiants,id',
            'diplome_id'     => 'required|exists:diplomes,id',
            'annee_id'       => 'required|exists:annees,id',
            'statut_resultat'=> 'required|in:admis,refuse,rattrapage',
        ]);

        $resultat = Resultat::updateOrCreate(
            [
                'etudiant_id' => $request->etudiant_id,
                'diplome_id'  => $request->diplome_id,
                'annee_id'    => $request->annee_id,
            ],
            [
                'statut_resultat' => $request->statut_resultat,
            ]
        );

        return response()->json($resultat, 201);
    }

    public function valider(Request $request)
    {
        $request->validate([
            'diplome_id' => 'required|exists:diplomes,id',
            'annee_id'   => 'required|exists:annees,id',
        ]);

        Resultat::where('diplome_id', $request->diplome_id)
            ->where('annee_id', $request->annee_id)
            ->update([
                'est_valide'      => true,
                'date_validation' => Carbon::now(),
            ]);

        return response()->json(['message' => 'Résultats validés avec succès.']);
    }

    // POST /api/resultats/publier
    public function publier(Request $request)
    {
        $request->validate([
            'diplome_id' => 'required|exists:diplomes,id',
            'annee_id'   => 'required|exists:annees,id',
        ]);

        Resultat::where('diplome_id', $request->diplome_id)
            ->where('annee_id', $request->annee_id)
            ->where('est_valide', true)
            ->update([
                'est_publie'       => true,
                'date_publication' => Carbon::now(),
            ]);

        return response()->json(['message' => 'Résultats publiés avec succès.']);
    }

    public function tauxReussite(Request $request)
    {
        $request->validate([
            'diplome_id' => 'required|exists:diplomes,id',
            'annee_id'   => 'required|exists:annees,id',
        ]);

        $resultats = Resultat::where('diplome_id', $request->diplome_id)
            ->where('annee_id', $request->annee_id)
            ->get();

        $total  = $resultats->count();
        $admis  = $resultats->where('statut_resultat', 'admis')->count();
        $taux   = $total > 0 ? round(($admis / $total) * 100, 2) : 0;

        $diplome = \App\Models\Diplome::find($request->diplome_id);
        $annee   = \App\Models\Annee::find($request->annee_id);

        return response()->json([
            'diplome'        => $diplome->nom,
            'annee'          => $annee->annee,
            'total'          => $total,
            'admis'          => $admis,
            'taux_reussite'  => $taux,
        ]);
    }

    public function show(Resultat $resultat)
    {
        return response()->json($resultat->load(['etudiant', 'diplome', 'annee']));
    }

    public function update(Request $request, Resultat $resultat)
    {
        $request->validate([
            'statut_resultat' => 'required|in:admis,refuse,rattrapage',
        ]);

        $resultat->update($request->only(['statut_resultat']));

        return response()->json($resultat);
    }

    public function destroy(Resultat $resultat)
    {
        $resultat->delete();
        return response()->json(null, 204);
    }
}
