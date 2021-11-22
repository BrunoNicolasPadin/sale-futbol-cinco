<?php

use App\Http\Controllers\Notificaciones\NotificacionController;
use App\Http\Controllers\Partidos\PartidoController;
use App\Http\Controllers\Postulaciones\PostulacionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('inicio');

Route::resource('partidos', PartidoController::class);

//Buscador de partidos
Route::post('partidos/filtrar', [PartidoController::class, 'filtrarPartidos'])
    ->name('partidos.filtrarPartidos');

Route::prefix('partidos/{partido:slug}')->group(function () {
    //Postulaciones
    Route::resource('postulaciones', PostulacionController::class)
        ->except(['create', 'edit']);

        Route::get('postulaciones-aceptados', [PostulacionController::class, 'obtenerPostulantesAceptados'])
            ->name('postulaciones.aceptados');
        
        Route::put('postulaciones/{postulacion_id}/calificar', [PostulacionController::class, 'calificarPostulacion'])
            ->name('postulaciones.calificar');
        Route::put('postulaciones/{postulacion_id}/actualizar-calificacion', [PostulacionController::class, 'actualizarCalificacion'])
            ->name('postulaciones.actualizarCalificacion');
        Route::delete('postulaciones/{postulacion_id}/eliminar-calificacion', [PostulacionController::class, 'eliminarCalificacion'])
            ->name('postulaciones.eliminarCalificacion');
    
    //Buscador de postulaciones
    /* Route::post('postulaciones/filtrar', [PostulacionController::class, 'filtrarPostulaciones'])
        ->name('postulaciones.filtrarPostulaciones'); */
});

//Notificaciones
Route::get('notificaciones', [NotificacionController::class, 'listar'])->name('notificaciones.listar');
Route::get('notificaciones/contar', [NotificacionController::class, 'contarNotificacionesSinLeer'])
    ->name('notificaciones.contarNotificacionesSinLeer');
Route::get('notificaciones/{notificacion_id}/marcar-como-leida', [NotificacionController::class, 'marcarComoLeida'])
    ->name('notificaciones.marcarComoLeida');
Route::get('notificaciones/marcar-todas-como-leidas', [NotificacionController::class, 'marcarTodasComoLeidas'])
    ->name('notificaciones.marcarTodasComoLeidas');

