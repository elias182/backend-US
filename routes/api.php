<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CancionesListasReproduccionController;
use App\Http\Controllers\ListaReproduccionController;

use App\http\Controllers\GeneroController;
use App\Http\Controllers\CancionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/useredit/{id}', [UserController::class, 'update']);
Route::post('registro',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);




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
Route::get('/eliminarsong/{id}', [CancionesListasReproduccionController::class, 'destroy']);
Route::get('/biblioteca/{id_usuario}', [ListaReproduccionController::class, 'getUserPlaylists']);
Route::get('/listarep/{id}', [ListaReproduccionController::class, 'show']);
Route::post('/actualizarlist/{id}', [ListaReproduccionController::class, 'updatePlaylist']);
Route::post('/crearlist', [ListaReproduccionController::class, 'store']);
Route::get('/eliminarlist/{id}', [ListaReproduccionController::class, 'deletePlaylist']);
//





Route::group(['middleware'=>['auth:sanctum']],function(){
Route::get('user-profile',[AuthController::class,'userProfile']);
Route::get('logout',[AuthController::class,'logout']);


});


