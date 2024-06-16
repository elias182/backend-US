<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'foto',
        'password',
        'type',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the songs associated with the user.
     */
    public function songs()
    {
        return $this->hasMany(Cancion::class, 'id_usuario');
    }

    /**
     * Get the playlists created by the user.
     */
    public function playlists()
    {
        return $this->hasMany(ListaReproduccion::class, 'id_usuario');
    }

    /**
     * Get the notes created by the user.
     */
    public function notes()
    {
        return $this->hasMany(Nota::class, 'id_usuario');
    }

    /**
     * Get the followers of the user.
     */
    public function followers()
    {
        return $this->hasMany(Seguidores::class, 'seguido');
    }

    /**
     * Get the users followed by the user.
     */
    public function followings()
    {
        return $this->hasMany(Seguidores::class, 'seguidor');
    }
}
