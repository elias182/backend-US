<?php

namespace App\Http\Controllers;

use App\Models\Seguidor;
use Illuminate\Http\Request;

class SeguidorController extends Controller
{
    public function index()
    {
        $seguidores = Seguidor::all();
        return response()->json($seguidores);
    }

    public function show($id)
    {
        $seguidor = Seguidor::findOrFail($id);
        return response()->json($seguidor);
    }

    public function store(Request $request)
    {
        $request->validate([
            'seguidor' => 'required|exists:users,id',
            'seguido' => 'required|exists:users,id',
        ]);

        $seguidor = Seguidor::create($request->all());

        return response()->json($seguidor, 201);
    }

    public function update(Request $request, $id)
    {
        $seguidor = Seguidor::findOrFail($id);

        $request->validate([
            'seguidor' => 'required|exists:users,id',
            'seguido' => 'required|exists:users,id',
        ]);

        $seguidor->update($request->all());

        return response()->json($seguidor);
    }

    public function destroy($id)
    {
        $seguidor = Seguidor::findOrFail($id);
        $seguidor->delete();

        return response()->json(null, 204);
    }
}
