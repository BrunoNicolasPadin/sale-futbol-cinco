<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use App\Services\Calificaciones\CalificacionPartidoService;
use App\Services\Calificaciones\CalificacionUsuarioService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PerfilController extends Controller
{
    protected $calificacionPartidoService;
    protected $calificacionUsuarioService;

    public function __construct(
        CalificacionPartidoService $calificacionPartidoService,
        CalificacionUsuarioService $calificacionUsuarioService
    ) {
        $this->calificacionPartidoService = $calificacionPartidoService;
        $this->calificacionUsuarioService = $calificacionUsuarioService;
    }

    public function mostrarPerfil($nombreUsuario)
    {
        $usuario = User::where('nombreUsuario', $nombreUsuario)
            ->first();
        return Inertia::render('Perfiles/Show', [
            'usuario' => $usuario,
            'calificacionOrganizador' => $this->calificacionPartidoService
                ->obtenerPromedioComoOrganizador($usuario->id),
            'calificacionJugador' => $this->calificacionUsuarioService
                ->obtenerPromedioComoJugador($usuario->id),
        ]);
    }

    public function mostrarPartidosOrganizados($nombreUsuario)
    {
        $usuario = User::where('nombreUsuario', $nombreUsuario)
            ->first();

        return Inertia::render('Perfiles/PartidosOrganizados', [
            'usuario' => $usuario,
            'partidos' => Partido::where('user_id', $usuario->id)
                ->with('user')
                ->orderBy('created_at', 'DESC')
                ->paginate(20)
                ->through(function ($partido) {
                    return [
                        'id' => $partido->id,
                        'nombre' => $partido->nombre,
                        'slug' => $partido->slug,
                        'lugar' => $partido->lugar,
                        'cuantosFaltan' => $partido->cuantosFaltan,
                        'precio' => $partido->precio,
                        'tipoDeCancha' => $partido->tipoDeCancha,
                        'estado' => $partido->estado,
                        'fechaHoraFinalizacion' => Carbon::parse(
                            $partido->fechaHoraFinalizacion
                        )->format('d/m/y - H:i:s'),
                        'user' => $partido->user,
                        'calificacion' => $this->calificacionPartidoService
                            ->obtenerCalificaciones($partido->id),
                    ];
                }),
        ]);
    }

    public function mostrarPostulacionesAceptadas(
        Request $request,
        $nombreUsuario
    ) {
        $request['estado'] = 'Aceptado';
        return Inertia::render('Perfiles/Postulaciones', [
            'usuario' => User::where('nombreUsuario', $nombreUsuario)
                ->first(),
            'partidos' => $this->filtrarPostulaciones(
                $request,
                $nombreUsuario
            ),
            'postulacionesAceptadas' => true,
        ]);
    }

    public function mostrarPostulacionesEnEspera(
        Request $request,
        $nombreUsuario
    ) {
        $request['estado'] = 'Esperando respuesta';
        return Inertia::render('Perfiles/Postulaciones', [
            'usuario' => User::where('nombreUsuario', $nombreUsuario)
                ->first(),
            'partidos' => $this->filtrarPostulaciones($request, $nombreUsuario),
            'postulacionesAceptadas' => false,
        ]);
    }

    public function filtrarPostulaciones(
        Request $request,
        $nombreUsuario
    ) {
        $usuario = User::where('nombreUsuario', $nombreUsuario)
            ->first();

        return Postulacion::where('user_id', $usuario->id)
            ->where('estado', $request->estado)
            ->with('partido.user')
            ->orderBy('created_at', 'DESC')
            ->paginate(20)
            ->through(function ($postulacion) {
                return [
                    'id' => $postulacion->partido->id,
                    'nombre' => $postulacion->partido->nombre,
                    'slug' => $postulacion->partido->slug,
                    'cuantosFaltan' => $postulacion->partido->cuantosFaltan,
                    'precio' => $postulacion->partido->precio,
                    'tipoDeCancha' => $postulacion->partido->tipoDeCancha,
                    'estado' => $postulacion->partido->estado,
                    'fechaHoraFinalizacion' => Carbon::parse(
                        $postulacion->partido->fechaHoraFinalizacion
                    )->format('d/m/y - H:i:s'),
                    'user' => $postulacion->partido->user,
                    'puntajeRecibido' => $postulacion->puntaje,
                ];
            });
    }
}
