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

        $postulacionesConCalificaciones = [];

        foreach ($postulaciones as $postulacion) {
            $postulacionesDelUsuario = Postulacion::where('user_id', $postulacion->user_id)
                ->where('estado', 'Aceptado')
                ->get();
                $puntajeSinPromedio = 0;

            foreach ($postulacionesDelUsuario as $postulacionUser) {
                if (array_key_exists($postulacionUser->user_id, $postulacionesConCalificaciones)) {

                    $puntajeSinPromedio = $puntajeSinPromedio + $postulacionUser->puntaje;

                    $postulacionesConCalificaciones[$postulacionUser->user_id]['partidos'] = 
                        $postulacionesConCalificaciones[$postulacionUser->user_id]['partidos'] + 1;

                    $postulacionesConCalificaciones[$postulacionUser->user_id]['puntaje'] = 
                        round($puntajeSinPromedio / $postulacionesConCalificaciones[$postulacionUser->user_id]['partidos']);
                } else {
                    $puntajeSinPromedio = $puntajeSinPromedio + $postulacionUser->puntaje;
                    $postulacionesConCalificaciones[$postulacionUser->user_id] = [
                        'id' => $postulacion->id,
                        'nombre' => $postulacion->user->name,
                        'puntaje' => round($postulacionUser->puntaje / 1, 2),
                        'partidos' => 1,
                    ];
                }
            }
        }
        return $postulacionesConCalificaciones;
    }
}
