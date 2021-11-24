<?php

use App\Http\Controllers\Auth\ResetearContrasenaController;
use App\Http\Controllers\Auth\VerificacionEmailController;
use App\Http\Controllers\Notificaciones\NotificacionController;
use App\Http\Controllers\Partidos\CalificacionPartidoController;
use App\Http\Controllers\Partidos\PartidoController;
use App\Http\Controllers\Perfiles\PerfilController;
use App\Http\Controllers\Postulaciones\PostulacionController;
use Illuminate\Support\Facades\Auth;
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
    $check = Auth::check();
    return Inertia::render('Welcome', [
        'canLogin' => $check = ($check === true) ? false : true,
        'canRegister' => Route::has('register'),
        /* 'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION, */
    ]);
})->name('inicio');

//VERIFICAR EMAIL AL REGISTRARSE

Route::get('email/verify', [VerificacionEmailController::class, 'avisarVerificacion'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('email/verify/{id}/{hash}', [VerificacionEmailController::class, 'verificar'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('email/verification-notification', [VerificacionEmailController::class, 'enviarVerificacion'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// RESETEAR CONTRASENA

Route::get('forgot-password', [ResetearContrasenaController::class, 'olvidoContrasena'])
    ->middleware('guest')
    ->name('password.request');

Route::post('forgot-password', [ResetearContrasenaController::class, 'enviarEmail'])
    ->middleware('guest')
    ->name('password.email');

Route::get('reset-password/{token}', [ResetearContrasenaController::class, 'resetear'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('reset-password', [ResetearContrasenaController::class, 'actualizarContrasena'])
    ->middleware('guest')
    ->name('password.update');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

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
    
    Route::resource('calificaciones', CalificacionPartidoController::class)
        ->except(['create', 'edit', 'show']);
});

//Notificaciones
Route::get('notificaciones', [NotificacionController::class, 'listar'])->name('notificaciones.listar');
Route::get('notificaciones/contar', [NotificacionController::class, 'contarNotificacionesSinLeer'])
    ->name('notificaciones.contarNotificacionesSinLeer');
Route::get('notificaciones/{notificacion_id}/marcar-como-leida', [NotificacionController::class, 'marcarComoLeida'])
    ->name('notificaciones.marcarComoLeida');
Route::get('notificaciones/marcar-todas-como-leidas', [NotificacionController::class, 'marcarTodasComoLeidas'])
    ->name('notificaciones.marcarTodasComoLeidas');

Route::prefix('perfil/{nombreUsuario}')->group(function () {
    Route::get('', [PerfilController::class, 'mostrarPerfil'])->name('perfil.mostrar');
    Route::get('partidos-organizados', [PerfilController::class, 'mostrarPartidosOrganizados'])->name('perfil.partidosOrganizados');
    Route::get('postulaciones-aceptadas', [PerfilController::class, 'mostrarPostulacionesAceptadas'])->name('perfil.postulacionesAceptadas');
    Route::get('postulaciones-en-espera', [PerfilController::class, 'mostrarPostulacionesEnEspera'])->name('perfil.postulacionesEnEspera');
    Route::post('filtrar-postulaciones', [PerfilController::class, 'filtrarPostulaciones'])
        ->name('perfil.filtrarPostulaciones');
});

