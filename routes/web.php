<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CancionesListasReproduccionController;
use App\Http\Controllers\ListaReproduccionController;

use App\http\Controllers\GeneroController;
use App\Http\Controllers\CancionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//usuario

Route::get('/artista/{id}', [UserController::class, 'show']);


//notas
Route::post('/notas', [NotaController::class, 'store']);
Route::post('/notasuser', [NotaController::class, 'getNotasByCancionAndUsuario']);
Route::post('/notasuserpropietario', [NotaController::class, 'getNotasByCancion']);
Route::get('/borrarnota/{id}', [NotaController::class, 'destroy']);
//

//buqueda
Route::get('/search/{query}', [SearchController::class, 'search']);

//canciones
Route::post('/anadircancion', [CancionController::class, 'store']);
Route::get('/usersongs/{id_usuario}', [CancionController::class, 'getUserSongs']);
Route::get('/cancion/{id}', [CancionController::class, 'show']);
Route::get('/borrarcancion/{id}', [CancionController::class, 'destroy']);
Route::post('/editarcancion/{id}', [CancionController::class, 'update']);

//fin canciones

//genero
Route::get('/api/generos', [GeneroController::class, 'index']);
//fin genero

//Listarep
Route::get('/listsprin', [ListaReproduccionController::class, 'index']);
Route::get('/canciones_listas/{id_lista}', [CancionesListasReproduccionController::class, 'index']);
Route::post('/expandirplaylist', [CancionesListasReproduccionController::class, 'store']);
Route::get('/biblioteca/{id_usuario}', [ListaReproduccionController::class, 'getUserPlaylists']);
Route::post('/actualizarlist/{id}', [ListaReproduccionController::class, 'updatePlaylist']);
Route::post('/crearlist', [ListaReproduccionController::class, 'store']);
Route::get('/eliminarlist/{id}', [ListaReproduccionController::class, 'deletePlaylist']);
//

// Almacenar un nuevo usuario en la base de datos
Route::post('/users', [UserController::class, 'store'])->name('usuarios.store');

// Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
// Mostrar los detalles de un usuario específico
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
//borrar usuario
Route::get('/borrarusuario/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
Route::get('/obtenerusuario/{id}', [UserController::class, 'obtenerusuario'])->name('usuarios.obtenerusuario');
Route::post('/guardarUsuario', [UserController::class, 'store'])->name('usuarios.store');
Route::put('/editarusuario/{id}', [UserController::class, 'update'])->name('usuarios.update');
//descargar archivo

//antes api.php
Route::post('registro',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('user-profile',[AuthController::class,'userProfile']);
    Route::get('logout',[AuthController::class,'logout']);
    });

// Mostrar el formulario para editar un usuario existente
// Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('usuarios.edit');

// Actualizar los detalles de un usuario en la base de datos
Route::put('/users/{user}', [UserController::class, 'update'])->name('usuarios.update');

// Eliminar un usuario de la base de datos
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');





Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');


Route::get('/csrf-token', function() {
    return response()->json([csrf_token()]);
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


require __DIR__.'/auth.php';
