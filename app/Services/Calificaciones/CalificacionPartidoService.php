<?php

namespace App\Services\Calificaciones;

use App\Models\Partidos\CalificacionPartido;
use App\Models\Partidos\Partido;

class CalificacionPartidoService
{
    public function obtenerCalificaciones($partido_id)
    {
        $calificaciones = CalificacionPartido::where(
            'partido_id',
            $partido_id
        )->get();

        $cantidad = $calificaciones->count();
        $calificacionDelPartido = collect();

        if ($cantidad == 0) {
            $calificacionDelPartido->put('puntaje', 0);
            $calificacionDelPartido->put('cantidad', 0);
            return $calificacionDelPartido;
        }

        $calificacionDelPartido->put('puntaje', round($calificaciones->sum('puntaje') /
            $cantidad, 2));
        $calificacionDelPartido->put('cantidad', $cantidad);

        return $calificacionDelPartido;
    }

    public function obtenerPromedioComoOrganizador($usuario_id)
    {
        $partidos = Partido::where('user_id', $usuario_id)->get();
        $calificaciones = collect([]);

        foreach ($partidos as $partido) {
            $calificaciones->push($this->obtenerCalificaciones($partido->id));
        }
        $votos = $calificaciones->sum('cantidad');
        $cantidad = $calificaciones->where('cantidad', '>', 0)->count();
        if ($cantidad == 0) {
            $cantidad = 1;
        }
        $calificacion = round($calificaciones->sum('puntaje') / $cantidad, 2);

        return [$calificacion, $votos];
    }
}
