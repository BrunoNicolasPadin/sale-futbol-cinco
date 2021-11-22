<?php

namespace App\Observers\Postulaciones;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use App\Notifications\Postulaciones\PostulacionActualizada;
use App\Notifications\Postulaciones\PostulacionCalificada;
use App\Notifications\Postulaciones\PostulacionEliminada;

class PostulacionObserver
{
    public function updated(Postulacion $postulacion)
    {
        $user = User::findOrFail($postulacion->user_id);

        if ($postulacion->wasChanged('estado')) {
            if ($postulacion->estado == 'Esperando respuesta') {
                $postulacion->puntaje = null;
                $postulacion->comentario = null;
                $postulacion->save();
            }
            $postulacion = Postulacion::with('partido')->findOrFail($postulacion->id);
            $user->notify(new PostulacionActualizada($postulacion));
        }
        if ($postulacion->wasChanged('puntaje')) {
            $postulacion = Postulacion::with('partido')->findOrFail($postulacion->id);
            $user->notify(new PostulacionCalificada($postulacion));
        }
    }

    public function deleted(Postulacion $postulacion)
    {
        $user = User::findOrFail($postulacion->user_id);
        $partido = Partido::findOrFail($postulacion->partido_id);
        $user->notify(new PostulacionEliminada($partido));
    }
}
