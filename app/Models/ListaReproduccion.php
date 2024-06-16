<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaReproduccion extends Model
{
    use HasFactory;
    protected $table = 'listas_reproduccion';

    protected $fillable = [
        'nombre',
        'descripcion',
        'privada',
        'id_usuario',
    ];

    /**
     * Get the user that owns the playlist.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Get the songs for the playlist.
     */
    public function songs()
    {
        return $this->belongsToMany(Canciones::class, 'canciones_listas_reproduccion', 'id_lista', 'id_cancion');
    }
}
