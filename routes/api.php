<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FiliereController;
use App\Http\Controllers\Api\DiplomeController;
use App\Http\Controllers\Api\EtudiantController;
use App\Http\Controllers\Api\AnneeController;



Route::apiResource('filieres', FiliereController::class);
Route::apiResource('diplomes', DiplomeController::class);
Route::apiResource('annees', AnneeController::class);
Route::apiResource('etudiants', EtudiantController::class);
