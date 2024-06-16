<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nota',
        'id_cancion',
        'id_usuario',
        'part_letra',
    ];

    /**
     * Get the song that owns the note.
     */
    public function song()
    {
        return $this->belongsTo(Canciones::class, 'id_cancion');
    }

    /**
     * Get the user that created the note.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
