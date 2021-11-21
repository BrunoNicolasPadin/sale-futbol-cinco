<?php

namespace Database\Factories\Postulaciones;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostulacionFactory extends Factory
{
    protected $model = Postulacion::class;

    public function definition()
    {
        return [
            'partido_id' => Partido::factory(),
            'user_id' => User::factory(),
            'estado' => 'Esperando respuesta',
        ];
    }
}
