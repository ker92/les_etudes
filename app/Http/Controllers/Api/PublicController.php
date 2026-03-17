<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Diplome;
use App\Models\Etudiant;
use App\Models\Resultat;
use App\Models\Annee;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * GET /api/public/filieres
     * Retourne toutes les filières avec leurs diplômes
     */
    public function filieres()
    {
        $filieres = Filiere::with('diplomes')->get();
        return response()->json($filieres);
    }

    /**
     * GET /api/public/stats
     * Retourne les statistiques globales pour la page d'accueil
     */
    public function stats()
    {
        return response()->json([
            'total_etudiants' => Etudiant::count(),
            'total_diplomes'  => Diplome::count(),
            'total_publies'   => Resultat::where('est_publie', true)->count(),
        ]);
    }

    /**
     * GET /api/public/taux-reussite?diplome_id=X&annee_id=Y (optionnel)
     * Sans paramètres : retourne tous les taux publiés (pour la page d'accueil)
     * Avec paramètres  : retourne le taux d'un diplôme/année précis
     */
    public function tauxReussite(Request $request)
    {
        // Avec paramètres → taux d'une session précise
        if ($request->has('diplome_id') && $request->has('annee_id')) {
            $request->validate([
                'diplome_id' => 'required|exists:diplomes,id',
                'annee_id'   => 'required|exists:annees,id',
            ]);

            $resultats = Resultat::where('diplome_id', $request->diplome_id)
                ->where('annee_id', $request->annee_id)
                ->where('est_publie', true)
                ->get();

            if ($resultats->isEmpty()) {
                return response()->json(['message' => 'Aucun résultat publié pour cette session.'], 404);
            }

            $total = $resultats->count();
            $admis = $resultats->where('statut_resultat', 'admis')->count();
            $taux  = $total > 0 ? round(($admis / $total) * 100, 2) : 0;

            $diplome = Diplome::find($request->diplome_id);
            $annee   = Annee::find($request->annee_id);

            return response()->json([
                'diplome'       => $diplome->nom,
                'annee'         => $annee->annee,
                'total'         => $total,
                'admis'         => $admis,
                'taux_reussite' => $taux,
            ]);
        }

        // Sans paramètres → tous les taux publiés (page d'accueil)
        $resultatsGroupes = Resultat::where('est_publie', true)
            ->with(['diplome', 'annee'])
            ->get()
            ->groupBy(fn($r) => $r->diplome_id . '-' . $r->annee_id);

        $taux = $resultatsGroupes->map(function ($groupe) {
            $total = $groupe->count();
            $admis = $groupe->where('statut_resultat', 'admis')->count();
            $premier = $groupe->first();

            return [
                'diplome_id'    => $premier->diplome_id,
                'annee_id'      => $premier->annee_id,
                'diplome'       => $premier->diplome->nom,
                'annee'         => $premier->annee->annee,
                'total'         => $total,
                'admis'         => $admis,
                'taux_reussite' => $total > 0 ? round(($admis / $total) * 100, 2) : 0,
            ];
        })->values();

        return response()->json($taux);
    }

    /**
     * GET /api/public/resultat?identifiant=XX&diplome_id=X&annee_id=Y
     * Recherche le résultat d'un étudiant par son identifiant unique (ou nom/prénom)
     */
    public function resultat(Request $request)
    {
        $request->validate([
            'identifiant' => 'required|string',
            'diplome_id'  => 'required|exists:diplomes,id',
            'annee_id'    => 'required|exists:annees,id',
        ]);

        $identifiant = $request->identifiant;

        // Cherche par identifiant_unique OU par nom OU par prénom
        $etudiant = Etudiant::where('diplome_id', $request->diplome_id)
            ->where(function ($query) use ($identifiant) {
                $query->where('identifiant_unique', $identifiant)
                    ->orWhere('nom',    'like', '%' . $identifiant . '%')
                    ->orWhere('prenom', 'like', '%' . $identifiant . '%');
            })
            ->with(['filiere', 'diplome'])
            ->first();

        if (!$etudiant) {
            return response()->json(['message' => 'Étudiant introuvable.'], 404);
        }

        // Récupère le résultat publié
        $resultat = Resultat::where('etudiant_id', $etudiant->id)
            ->where('diplome_id', $request->diplome_id)
            ->where('annee_id',   $request->annee_id)
            ->where('est_publie', true)
            ->first();

        if (!$resultat) {
            return response()->json(['message' => 'Résultat non encore publié pour cet étudiant.'], 404);
        }

        return response()->json([
            'id'                => $etudiant->id,
            'nom'               => $etudiant->nom,
            'prenom'            => $etudiant->prenom,
            'identifiant_unique' => $etudiant->identifiant_unique,
            'filiere'           => $etudiant->filiere,
            'diplome'           => $etudiant->diplome,
            'statut_resultat'   => $resultat->statut_resultat,
        ]);
    }
}
