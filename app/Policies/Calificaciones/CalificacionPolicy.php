<?php

namespace App\Policies\Calificaciones;

use App\Models\Partidos\CalificacionPartido;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalificacionPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Partido $partido)
    {
        if (Postulacion::where('user_id', $user->id)
            ->where('partido_id', $partido->id)
            ->where('estado', 'Aceptado')
            ->exists()) {
            return true;
        }
        return false;
    }

    public function update(User $user, CalificacionPartido $calificacionPartido)
    {
        if ($user->id == $calificacionPartido->user_id) {
            return true;
        }
        return false;
    }
}
