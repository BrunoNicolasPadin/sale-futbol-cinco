<?php

namespace App\Policies\Partidos;

use App\Models\Partidos\Partido;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartidoPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Partido $partido)
    {
        return $this->verificarCreador($user, $partido);
    }

    public function delete(User $user, Partido $partido)
    {
        return $this->verificarCreador($user, $partido);
    }

    public function verificarCreador($user, $partido)
    {
        if ($user->id === $partido->user_id) {
            return true;
        }
        return false;
    }
}
