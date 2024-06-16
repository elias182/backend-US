<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        $notas = Nota::all();
        return response()->json($notas);
    }
    public function getNotasByCancionAndUsuario(Request $request)
    {
        $request->validate([
            'cancion_id' => 'required|exists:canciones,id',
            'usuario_id' => 'required|exists:users,id',
        ]);

        $notas = Nota::where('id_cancion', $request->cancion_id)
                     ->where('id_usuario', $request->usuario_id)
                     ->get();

        return response()->json($notas);
    }

    public function getNotasByCancion(Request $request)
    {
        $request->validate([
            'cancion_id' => 'required|exists:canciones,id',
        ]);

        $notas = Nota::where('id_cancion', $request->cancion_id)
                     ->get();

        return response()->json($notas);
    }

    public function show($id)
    {
        $nota = Nota::findOrFail($id);
        return response()->json($nota);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nota' => 'required|string',
            'id_cancion' => 'required|exists:canciones,id',
            'id_usuario' => 'required|exists:users,id',
            'part_letra' => 'required|integer',
        ]);

        $nota = Nota::create($request->all());

        return response()->json($nota, 201);
    }

    public function update(Request $request, $id)
    {
        $nota = Nota::findOrFail($id);

        $request->validate([
            'nota' => 'required|string',
            'id_cancion' => 'required|exists:canciones,id',
            'id_usuario' => 'required|exists:users,id',
            'part_letra' => 'required|integer',
        ]);

        $nota->update($request->all());

        return response()->json($nota);
    }

    public function destroy($id)
    {
        $nota = Nota::findOrFail($id);
        $nota->delete();

        return response()->json(null, 204);
    }
}
