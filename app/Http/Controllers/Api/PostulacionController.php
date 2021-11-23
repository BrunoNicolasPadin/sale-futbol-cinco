<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Services\Calificaciones\CalificacionPostulacionService;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    protected $calificacionPostulacionService;

    public function __construct(
        CalificacionPostulacionService $calificacionPostulacionService
    ) {
        $this->calificacionPostulacionService = $calificacionPostulacionService;
    }

    public function obtenerPostulacionesEnEspera($partido_id)
    {
        $partido = Partido::findOrFail($partido_id);

        return $this->calificacionPostulacionService
            ->obtenerCalificaciones(
                $partido->id,
                'Esperando respuesta'
            );
    }

    public function obtenerPostulacionesAceptadas($partido_id)
    {
        $partido = Partido::findOrFail($partido_id);

        return $this->calificacionPostulacionService
            ->obtenerCalificaciones(
                $partido->id,
                'Aceptado'
            );
    }

    public function obtenerDetallesDeLaPostulacion(
        $partido_id,
        $postulacion_id
    ) {
        return Postulacion::with('user')
            ->findOrFail($postulacion_id);
    }
}
