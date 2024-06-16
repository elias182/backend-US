<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'letra',
        'id_genero',
        'archivo_audio',
        'portada',
        'visitas',
        'id_usuario'
    ];

    /**
     * Get the genre of the song.
     */
    public function genre()
    {
        return $this->belongsTo(Genero::class, 'id_genero');
    }

    /**
     * Get the notes for the song.
     */
    public function notes()
    {
        return $this->hasMany(Nota::class, 'id_cancion');
    }

    /**
     * Get the playlists that contain the song.
     */
    public function playlists()
    {
        return $this->belongsToMany(ListaReproduccion::class, 'canciones_listas_reproduccion', 'id_cancion', 'id_lista');
    }
}
