<?php

namespace App\Services\Calificaciones;

use App\Models\Postulaciones\Postulacion;

class CalificacionUsuarioService
{
    public function obtenerPromedioComoJugador($usuario_id)
    {
        $postulaciones = Postulacion::where('user_id', $usuario_id)->get();

        $cantidad = $postulaciones->where('puntaje', '<>', null)->count();
        if ($cantidad == 0) {
            $cantidad = 1;
        }
        $calificacion = round($postulaciones->sum('puntaje') / $cantidad, 2);

        return [$calificacion, $cantidad];
    }
}
