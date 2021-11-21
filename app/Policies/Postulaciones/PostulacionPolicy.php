<?php

namespace App\Policies\Postulaciones;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostulacionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, $partido)
    {
        return $this->verificarOrganizadorPostulador(
            $user,
            $partido
        );
    }

    public function verAceptados(User $user, $partido)
    {
        return $this->verificarOrganizadorPostulador(
            $user,
            $partido
        );
    }

    public function create(User $user, Partido $partido)
    {
        if ($user->id === $partido->user_id) {
            return false;
        }
        if (Partido::where('estado', 'Buscando jugadores')
            ->findOrFail($partido->id)->exists()) {
            return true;
        }
        return false;
    }

    public function update(
        User $user,
        Partido $partido,
        Postulacion $postulacion
    ) {
        if ($user->id === $partido->user_id) {
            return true;
        }
        return $this->verificarOrganizadorPostulador(
            $user,
            $postulacion
        );
    }

    public function delete(User $user, Postulacion $postulacion)
    {
        return $this->verificarOrganizadorPostulador(
            $user,
            $postulacion
        );
    }

    public function verificarOrganizadorPostulador(
        $user,
        $partidoPostulacion
    ) {
        if ($user->id === $partidoPostulacion->user_id) {
            return true;
        }
        return false;
    }
}
