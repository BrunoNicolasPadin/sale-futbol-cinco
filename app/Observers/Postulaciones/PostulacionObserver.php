<?php

namespace App\Observers\Postulaciones;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use App\Notifications\Postulaciones\PostulacionActualizada;
use App\Notifications\Postulaciones\PostulacionEliminada;

class PostulacionObserver
{
    public function updated(Postulacion $postulacion)
    {
        $user = User::findOrFail($postulacion->user_id);
        $postulacion = $postulacion->with('partido')->first();
        $user->notify(new PostulacionActualizada($postulacion));
    }

    public function deleted(Postulacion $postulacion)
    {
        $user = User::findOrFail($postulacion->user_id);
        $partido = Partido::findOrFail($postulacion->partido_id);
        $user->notify(new PostulacionEliminada($partido));
    }
}
