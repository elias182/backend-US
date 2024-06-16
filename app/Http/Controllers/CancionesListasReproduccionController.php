<?php

namespace App\Http\Controllers;

use App\Models\CancionesListasReproduccion;
use App\Models\ListaReproduccion;
use Illuminate\Http\Request;
use App\Models\Canciones;
use App\Http\Controllers\UserController;

class CancionesListasReproduccionController extends Controller
{
    public function index($id_lista)
    {
        // Obtener las relaciones de la lista de reproducción por id_lista
        $relaciones = CancionesListasReproduccion::where('id_lista', $id_lista)->get();

        // Obtener los ids de las canciones
        $id_canciones = $relaciones->pluck('id_cancion');

        // Obtener las canciones por ids
        $canciones = Canciones::whereIn('id', $id_canciones)->get();
        $userController = new UserController();

        $canciones->each(function ($cancion) use ($userController) {
            $response = $userController->obtart($cancion->id_usuario);
            $artistData = $response->getData();
            $cancion->artista = $artistData;
        });
        return response()->json($canciones);
    }
    public function show($id)
    {
        $relacion = CancionesListasReproduccion::findOrFail($id);
        return response()->json($relacion);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cancion' => 'required|exists:canciones,id',
            'id_lista' => 'required|exists:listas_reproduccion,id',
        ]);

        $relacion = CancionesListasReproduccion::create($request->all());

        return response()->json($relacion, 201);
    }

    public function update(Request $request, $id)
    {
        $relacion = CancionesListasReproduccion::findOrFail($id);

        $request->validate([
            'id_cancion' => 'required|exists:canciones,id',
            'id_lista' => 'required|exists:listas_reproduccion,id',
        ]);

        $relacion->update($request->all());

        return response()->json($relacion);
    }

    public function destroy($id)
{
    
    $relacion = CancionesListasReproduccion::findOrFail($id);


    $relacion->delete();

    return response()->json(null, 204);
}

}
