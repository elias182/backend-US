<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ListaReproduccion;
use App\Models\Canciones;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search($query)
    {
        $users = User::where('name', 'like', "%$query%")
             ->where('type', 'artist') // Cambia 'like' a '='
             ->get();
        $playlists = ListaReproduccion::where('nombre', 'like', "%$query%")->get();
        $songs = Canciones::where('titulo', 'like', "%$query%")->get();
        
        return response()->json([
            'users' => $users,
            'playlists' => $playlists,
            'songs' => $songs,
        ]);
    }
}