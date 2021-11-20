<?php

namespace App\Observers\Partidos;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;

class PartidoObserver
{
    public function updated(Partido $partido)
    {
        if ($partido->estado === 'Busqueda finalizada') {
            $postulaciones = Postulacion::where(
                'partido_id',
                $partido->id
            )->where('estado', 'Esperando respuesta')
                ->get();

            $this->eliminarPostulaciones($postulaciones);
        }
    }

    public function eliminarPostulaciones($postulaciones)
    {
        foreach ($postulaciones as $postulacion) {
            Postulacion::destroy($postulacion->id);
        }
    }
}
