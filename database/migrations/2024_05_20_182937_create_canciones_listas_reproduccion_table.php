<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('canciones_listas_reproduccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cancion')->constrained('canciones')->onDelete('cascade');
            $table->foreignId('id_lista')->constrained('listas_reproduccion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canciones_listas_reproduccion');
    }
};
