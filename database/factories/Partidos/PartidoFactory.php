<?php

namespace Database\Factories\Partidos;

use App\Models\Partidos\Partido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PartidoFactory extends Factory
{
    protected $model = Partido::class;

    public function definition()
    {
        $nombre = $this->faker->name();
        return [
            'user_id' => User::factory(),
            'nombre' => $nombre,
            'slug' => Str::slug($nombre),
            'detalles' => $this->faker->text(),
            'fechaHoraFinalizacion' => $this->faker->dateTime(),
            'lugar' => $this->faker->address(),
            'cuantosFaltan' => 2,
            'tipoDeCancha' => 7,
            'precio' => 500,
            'estado' => 'Buscando jugadores',
        ];
    }
}
