<?php

namespace App\Observers\Partidos;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use App\Notifications\Postulaciones\PostulacionEliminada;

class PartidoObserver
{
    public function updated(Partido $partido)
    {
        if ($partido->estado == 'Busqueda finalizada') {
            $postulaciones = Postulacion::where('partido_id', $partido->id)
                ->where('estado', 'Esperando respuesta')
                ->get();
            foreach ($postulaciones as $postulacion) {
                Postulacion::destroy($postulacion->id);
            }
        }
    }
}
