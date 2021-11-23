<?php

use App\Http\Controllers\Api\PartidoController;
use App\Http\Controllers\Api\PostulacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('partidos', [PartidoController::class, 'obtenerPartidos']);
Route::get('partidos/{partido_id}', [PartidoController::class, 'obtenerDatosDelPartido']);

Route::get('partidos/{partido_id}/postulaciones-en-espera', [PostulacionController::class, 'obtenerPostulacionesEnEspera']);
Route::get('partidos/{partido_id}/postulaciones-aceptadas', [PostulacionController::class, 'obtenerPostulacionesAceptadas']);
Route::get('partidos/{partido_id}postulaciones/{postulacion_id}', [PostulacionController::class, 'obtenerDetallesDeLaPostulacion']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
