<?php


use App\Http\Controllers\Api\FiliereController;
use App\Http\Controllers\Api\DiplomeController;
use App\Http\Controllers\Api\EtudiantController;
use App\Http\Controllers\Api\AnneeController;
use App\Http\Controllers\Api\ResultatController;


Route::get('/filieres', [FiliereController::class, 'index']);
Route::post('/filieres', [FiliereController::class, 'store']);



Route::apiResource('filieres', FiliereController::class);
Route::apiResource('diplomes', DiplomeController::class);
Route::apiResource('annees', AnneeController::class);
Route::apiResource('etudiants', EtudiantController::class);
Route::apiResource('resultats', ResultatController::class);
