
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FiliereController;
use App\Http\Controllers\Api\DiplomeController;
use App\Http\Controllers\Api\EtudiantController;
use App\Http\Controllers\Api\AnneeController;
use App\Http\Controllers\Api\ResultatController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Auth\AuthController;

Route::post('login', [AuthController::class, 'login']);

Route::prefix('public')->group(function () {
    Route::get('filieres',      [PublicController::class, 'filieres']);
    Route::get('stats',         [PublicController::class, 'stats']);
    Route::get('taux-reussite', [PublicController::class, 'tauxReussite']);
    Route::get('resultat',      [PublicController::class, 'resultat']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get ('resultats/etudiants',     [ResultatController::class, 'etudiantsParDiplomeAnnee']);
    Route::post('resultats/valider',       [ResultatController::class, 'valider']);
    Route::post('resultats/publier',       [ResultatController::class, 'publier']);
    Route::get ('resultats/taux-reussite', [ResultatController::class, 'tauxReussite']);

    Route::apiResource('filieres',  FiliereController::class);
    Route::apiResource('diplomes',  DiplomeController::class);
    Route::apiResource('annees',    AnneeController::class);
    Route::apiResource('etudiants', EtudiantController::class);
    Route::apiResource('resultats', ResultatController::class);
});