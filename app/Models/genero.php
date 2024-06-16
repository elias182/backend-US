<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    /**
     * Get the songs for the genre.
     */
    public function songs()
    {
        return $this->hasMany(Cancion::class, 'id_genero');
    }
}
