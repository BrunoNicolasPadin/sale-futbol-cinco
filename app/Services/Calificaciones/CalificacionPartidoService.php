<?php

namespace App\Services\Calificaciones;

use App\Models\Partidos\CalificacionPartido;

class CalificacionPartidoService
{
    public function obtenerCalificaciones($partido_id)
    {
        $calificaciones = CalificacionPartido::where(
            'partido_id',
            $partido_id
        )
        ->selectRaw(
            'SUM(calificaciones_partidos.puntaje) AS puntaje,
            COUNT(calificaciones_partidos.id) AS cantidad'
        )->first();

        $calificacionDelPartido = [];

        if ($calificaciones->cantidad == 0) {
            $calificacionDelPartido['puntaje'] = 0;
            $calificacionDelPartido['cantidad'] = 0;
            return $calificacionDelPartido;
        }

        $calificacionDelPartido['puntaje'] = round($calificaciones->puntaje /
            $calificaciones->cantidad, 2);
        $calificacionDelPartido['cantidad'] = $calificaciones->cantidad;

        return $calificacionDelPartido;
    }
}
