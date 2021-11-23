<?php

namespace App\Policies\Partidos;

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
            return $this->verificarCalificacionYaHecha(
                $user,
                $partido
            );
        }
        return false;
    }

    public function verificarCalificacionYaHecha($user, $partido)
    {
        if (CalificacionPartido::where('user_id', $user->id)
            ->where('partido_id', $partido->id)
            ->exists()) {
            return false;
        }
        return true;
    }

    public function verificarQueCoincidaElUsuario(
        User $user,
        CalificacionPartido $calificacionPartido
    ) {
        if ($user->id === $calificacionPartido->user_id) {
            return true;
        }
        return false;
    }
}
