<?php

namespace App\Http\Controllers;

use App\Models\Canciones;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class CancionController extends Controller
{
    public function index()
    {
        $canciones = Canciones::all();
        return response()->json($canciones);
    }
    public function getUserSongs($id_usuario)
{
    // Obtener todas las listas de reproducción que pertenecen al usuario con el ID especificado
    $canciones = Canciones::where('id_usuario', $id_usuario)->get();
    
    // Devolver las listas de reproducción en formato JSON
    return response()->json($canciones);
}




    public function show($id)
    {
        $cancion = Canciones::findOrFail($id);
        $userController = new UserController();
        $response = $userController->obtart($cancion->id_usuario);
        $artistData = $response->getData();
        $cancion->artista = $artistData;
        return response()->json($cancion);
    }

    public function store(Request $request)
{
    try {
        $request->validate(['archivo_audio' => 'required|file|mimes:mp3,wav',]);
    }catch(\Illuminate\Validation\ValidationException $e){
        return response()->json($request->archivo_audio);
    }
    
    try {
        $request->validate([
            'titulo' => 'string|max:255',
            'letra' => 'nullable|string',
            'id_genero' => 'required|exists:generos,id',
            'portada' => 'nullable|file|mimes:jpeg,png,jpg',
            'archivo_audio' => 'nullable|file|mimes:mp3,wav',
            'id_usuario' => 'required'
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        $errors = $e->errors();
        return response()->json(['error' => 'Validación fallida.', 'details' => $errors], 422);
    }
    
    try {
        $data = $request->all();
        
        $data['id_usuario'] = $request->id_usuario; // Asignar el ID del usuario autenticado o 1

        // Manejo de archivo de audio
        if ($request->hasFile('archivo_audio')) {
            $archivoAudio = $request->file('archivo_audio');
            $audioPath = 'audios/' . $archivoAudio->getClientOriginalName();
            $archivoAudio->move(public_path('audios'), $archivoAudio->getClientOriginalName());
            $data['archivo_audio'] = $audioPath;
        } else {
            throw new \Exception('El archivo de audio no fue recibido.');
        }

        // Manejo de portada
        if ($request->hasFile('portada')) {
            $portada = $request->file('portada');
            $portadaPath = 'portadas/' . $portada->getClientOriginalName();
            $portada->move(public_path('portadas'), $portada->getClientOriginalName());
            $data['portada'] = $portadaPath;
        } else {
            $data['portada'] = null;
        }

        // Particionar la letra y guardarla como JSON
        $letraParticionada = [];
        $lineasLetra = explode("\n", $data['letra']);
        foreach ($lineasLetra as $index => $linea) {
            if (!empty(trim($linea))) {
                $letraParticionada[] = [$index + 1 => trim($linea)];
            }
        }
        $data['letra'] = $request->letra;

        $cancion = Canciones::create([
            'titulo' => $data['titulo'],
            'letra' => $data['letra'],
            'id_genero' => $data['id_genero'],
            'archivo_audio' => $data['archivo_audio'],
            'portada' => $data['portada'],
            'id_usuario' => $data['id_usuario'],
        ]);

        $userController = new UserController();
        $userController->changeUserType($data['id_usuario']);

        return response()->json($cancion, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Hubo un error al procesar la solicitud.', 'exception' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
    }
}




public function update(Request $request, $id)
{
    $cancion = Canciones::findOrFail($id);

    try {
        $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'id_genero' => 'sometimes|required|exists:generos,id',
            'archivo_audio' => 'nullable|file|mimes:mp3,wav',
            'portada' => 'nullable|file|mimes:jpeg,png,jpg',
        ]);

        $data = $request->all();

        // Verificar si se proporcionó un nuevo archivo de audio
        if ($request->hasFile('archivo_audio')) {
            $archivoAudio = $request->file('archivo_audio');
            $audioPath = 'audios/' . $archivoAudio->getClientOriginalName();
            $archivoAudio->move(public_path('audios'), $archivoAudio->getClientOriginalName());
            $data['archivo_audio'] = $audioPath;
        } else {
            // Mantener el archivo de audio existente
            $data['archivo_audio'] = $cancion->archivo_audio;
        }

        // Manejo de portada
        if ($request->hasFile('portada')) {
            $portada = $request->file('portada');
            $portadaPath = 'portadas/' . $portada->getClientOriginalName();
            $portada->move(public_path('portadas'), $portada->getClientOriginalName());
            $data['portada'] = $portadaPath;
        } else {
            // Eliminar la portada si no se recibe
            unset($data['portada']);
        }

        $cancion->update($data);

        return response()->json($cancion);
    } catch (\Illuminate\Validation\ValidationException $e) {
        $errors = $e->errors();
        return response()->json(['error' => 'Validación fallida.', 'details' => $errors], 422);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Hubo un error al procesar la solicitud.', 'exception' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
    }
}


    public function destroy($id)
    {
        $cancion = Canciones::findOrFail($id);
        $cancion->delete();

        return response()->json("eliminada correctamente", 204);
    }
}
