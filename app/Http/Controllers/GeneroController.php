<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function index()
    {
        $generos = Genero::all();
        return response()->json($generos);
    }

    public function show($id)
    {
        $genero = Genero::findOrFail($id);
        return response()->json($genero);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $genero = Genero::create($request->all());

        return response()->json($genero, 201);
    }

    public function update(Request $request, $id)
    {
        $genero = Genero::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $genero->update($request->all());

        return response()->json($genero);
    }

    public function destroy($id)
    {
        $genero = Genero::findOrFail($id);
        $genero->delete();

        return response()->json(null, 204);
    }
}
