<?php

namespace App\Http\Controllers;

use App\Models\ListaReproduccion;
use Illuminate\Http\Request;

class ListaReproduccionController extends Controller
{
    public function index(Request $request)
{
    return "dsdf";
    // Obtener el id_usuario de los parámetros de la solicitud o usar 1 como valor por defecto
    $idUsuario = $request->input('id_usuario', 1);
    
    // Obtener todas las listas de reproducción que pertenecen al usuario con id_usuario especificado
    $listas = ListaReproduccion::where('id_usuario', $idUsuario)->get();
    
    // Devolver las listas en formato JSON
    return response()->json($listas);
}
public function getUserPlaylists($id_usuario)
{
    // Obtener todas las listas de reproducción que pertenecen al usuario con el ID especificado
    $listas = ListaReproduccion::where('id_usuario', $id_usuario)->get();
    
    // Devolver las listas de reproducción en formato JSON
    return response()->json($listas);
}

   public function show($id)
{
    $lista = ListaReproduccion::with(['user', 'songs' => function ($query) {
        $query->withPivot('id'); // Incluir el ID de la relación de la tabla intermedia
    }])->findOrFail($id);

    return response()->json($lista);
}

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'privada' => 'required|boolean',
            'id_usuario' => 'required|exists:users,id',
        ]);
        

        $lista = ListaReproduccion::create($request->all());

        return response()->json($lista, 201);
    }

    public function updatePlaylist(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        
    ]);

    $playlist = ListaReproduccion::findOrFail($id);
    $playlist->update($request->only('nombre'));

    return response()->json($playlist);
}

public function deletePlaylist($id)
{
    $playlist = ListaReproduccion::findOrFail($id);
    $playlist->delete();

    return response()->json(['message' => 'Playlist deleted successfully']);
}
}
