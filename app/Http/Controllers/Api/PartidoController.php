<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partidos\Partido;
use App\Services\Calificaciones\CalificacionPartidoService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PartidoController extends Controller
{
    protected $calificacionPartidoService;

    public function __construct(
        CalificacionPartidoService $calificacionPartidoService
    ) {
        $this->calificacionPartidoService = $calificacionPartidoService;
    }

    public function obtenerPartidos(Request $request)
    {
        return Partido::with('user:id,name,nombreUsuario')
            ->filtrar($request)
            ->orderBy('created_at', 'DESC')
            ->paginate(20)
            ->through(function ($partido) {
                return [
                    'id' => $partido->id,
                    'nombre' => $partido->nombre,
                    'slug' => $partido->slug,
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
            });
    }

    public function obtenerDatosDelPartido($partido_id)
    {
        $partido = Partido::with('user:id,name,nombreUsuario')
            ->findOrFail($partido_id);

        return [
            'id' => $partido->id,
            'user_id' => $partido->user_id,
            'nombre' => $partido->nombre,
            'slug' => $partido->slug,
            'lugar' => $partido->lugar,
            'cuantosFaltan' => $partido->cuantosFaltan,
            'precio' => $partido->precio,
            'estado' => $partido->estado,
            'detalles' => $partido->detalles,
            'tipoDeCancha' => $partido->tipoDeCancha,
            'fechaHoraFinalizacion' => Carbon::parse(
                $partido->fechaHoraFinalizacion
            )->format('d/m/Y - H:i:s'),
            'user' => $partido->user,
            'calificacionOrganizador' => $this->calificacionPartidoService
                ->obtenerPromedioComoOrganizador($partido->user->id),
        ];
    }
}
