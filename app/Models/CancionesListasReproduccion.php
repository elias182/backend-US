<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancionesListasReproduccion extends Model
{
    use HasFactory;
    protected $table = 'canciones_listas_reproduccion';

    protected $fillable = [
        'id_cancion',
        'id_lista',
    ];


    public function song()
    {
        return $this->belongsTo(Canciones::class, 'id_cancion');
    }


    public function playlist()
    {
        return $this->belongsTo(ListaReproduccion::class, 'id_lista');
    }
}
