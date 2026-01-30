<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Annee;
use Illuminate\Http\Request;

class AnneeController extends Controller
{
    public function index()
    {
        return response()->json(Annee::all());
    }

    public function store(Request $request)
    {
        $annee = Annee::create($request->validate([
            'annee' => 'required|string|max:255',
        ]));

        return response()->json($annee, 201);
    }

    public function show(Annee $annee)
    {
        return response()->json($annee);
    }

    public function update(Request $request, Annee $annee)
    {
        $annee->update($request->validate([
            'annee' => 'required|string|max:255',
        ]));

        return response()->json($annee);
    }

    public function destroy(Annee $annee)
    {
        $annee->delete();
        return response()->json(null, 204);
    }
}
