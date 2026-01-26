<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    // GET /api/filieres
    public function index()
    {
        return response()->json(Filiere::all());
    }

    // POST /api/filieres
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $filiere = Filiere::create($validated);

        return response()->json($filiere, 201);
    }

    // PUT /api/filieres/{id}
    public function update(Request $request, Filiere $filiere)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $filiere->update($validated);

        return response()->json($filiere);
    }

    // DELETE /api/filieres/{id}
    public function destroy(Filiere $filiere)
    {
        $filiere->delete();

        return response()->json(null, 204);
    }
}
