<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguidor extends Model
{
    use HasFactory;

    protected $fillable = [
        'seguidor',
        'seguido',
    ];

    /**
     * Get the user that follows another user.
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'seguidor');
    }

    /**
     * Get the user that is being followed.
     */
    public function followed()
    {
        return $this->belongsTo(User::class, 'seguido');
    }
}
