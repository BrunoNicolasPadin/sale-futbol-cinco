<?php

namespace Database\Factories\Partidos;

use App\Models\Partidos\CalificacionPartido;
use App\Models\Partidos\Partido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalificacionPartidoFactory extends Factory
{
    protected $model = CalificacionPartido::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'partido_id' => Partido::factory(),
            'puntaje' => 8,
            'comentario' => null,
        ];
    }
}
