<?php

namespace App\Services\Calificaciones;

use App\Models\Postulaciones\Postulacion;

class CalificacionPostulacionService
{
    public function obtenerCalificaciones($partido_id, $estado)
    {
        $postulaciones = Postulacion::where('partido_id', $partido_id)
            ->where('estado', $estado)
            ->with('user')
            ->orderBy('created_at', 'ASC')
            ->get();

        return $this->obtenerPostulacionesAceptadasDeCadaPostulante(
            $postulaciones
        );
    }

    public function obtenerPostulacionesAceptadasDeCadaPostulante(
        $postulaciones
    ) {
        $calificaciones = [];
        foreach ($postulaciones as $postulacion) {
            $postulacionesDelUsuario = Postulacion::where(
                'user_id',
                $postulacion->user_id
            )->where('estado', 'Aceptado')->get();

            $puntajeSinPromedio = 0;

            $calificaciones =
                $this->obtenerCalificacionEnCadaPostulacion(
                    $postulacion,
                    $postulacionesDelUsuario,
                    $calificaciones,
                    $puntajeSinPromedio
                );
        }
        return $calificaciones;
    }

    public function obtenerCalificacionEnCadaPostulacion(
        $postulacion,
        $postulacionesDelUsuario,
        $calificaciones,
        $puntajeSinPromedio
    ) {
        foreach ($postulacionesDelUsuario as $postulacionUser) {
            if (array_key_exists(
                $postulacionUser->user_id,
                $calificaciones
            )) {
                $puntajeSinPromedio += $postulacionUser->puntaje;
                $calificaciones[$postulacionUser->user_id]['partidos'] += 1;
                $calificaciones[$postulacionUser->user_id]['puntaje'] =
                    round($puntajeSinPromedio /
                        $calificaciones[$postulacionUser->user_id]['partidos']);
            } else {
                $puntajeSinPromedio += $postulacionUser->puntaje;
                $calificaciones[$postulacionUser->user_id] =
                    $this->crearCalificacion($postulacion, $postulacionUser);
            }
        }
        return $calificaciones;
    }

    public function crearCalificacion($postulacion, $postulacionUser)
    {
        return [
            'id' => $postulacion->id,
            'nombre' => $postulacion->user->name,
            'puntaje' => round($postulacionUser->puntaje / 1, 2),
            'partidos' => 1,
        ];
    }
}
