<?php

namespace Tests\Unit\Postulaciones;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use Tests\TestCase;

class CalificacionTest extends TestCase
{
    public function test_solo_el_creador_y_el_jugador_pueden_ver_la_calificacion()
    {
        $partido = Partido::factory()->create();
        $partido = Partido::with('user')
            ->findOrFail($partido->id);

        $postulacion = Postulacion::factory()->create([
            'partido_id' => $partido->id,
        ]);

        //El creador del partido puede ver la calificacion que le dio a un postulante aceptado
        $response = $this->actingAs($partido->user)->get(route('postulaciones.show', [$partido->slug, $postulacion->id]));
        $response->assertStatus(200);

        //Un jugador postulado puede ver la calificacion recibida
        $postulacion = Postulacion::with('user')
            ->findOrFail($postulacion->id);
        $response = $this->actingAs($postulacion->user)->get(route('postulaciones.show', [$partido->slug, $postulacion->id]));
        $response->assertStatus(200);

        //Un jugador postulado no puede ver la calificacion de otro jugador
        $otraPostulacion = Postulacion::factory()->create([
            'partido_id' => $partido->id,
        ]);
        $otraPostulacion = Postulacion::with('user')
            ->findOrFail($otraPostulacion->id);
        $response = $this->actingAs($otraPostulacion->user)->get(route('postulaciones.show', [$partido->slug, $postulacion->id]));
        $response->assertStatus(403);
    }

    public function test_solo_el_creador_puede_calificar()
    {
        $partido = Partido::factory()->create();
        $partido = Partido::with('user')
            ->findOrFail($partido->id);

        $postulacion = Postulacion::factory()->create([
            'partido_id' => $partido->id,
        ]);

        $request = [];
        $request['puntaje'] = 1;
        $request['comentario'] = null;

        //El creador del partido solo puede calificar
        $response = $this->actingAs($partido->user)->put(route('postulaciones.calificar', [$partido->slug, $postulacion->id]), $request);
        $response->assertRedirect(route('postulaciones.show', [$partido->slug, $postulacion->id]));

        //El jugador postulado no puede califcarse
        $postulacion = Postulacion::with('user')
            ->findOrFail($postulacion->id);
        $response = $this->actingAs($postulacion->user)->put(route('postulaciones.calificar', [$partido->slug, $postulacion->id]), $request);
        $response->assertStatus(403);

        //El creador de un partido  no puede calificar a los postulantes aceptados de un partido que no creo
        $postulacionNueva = Postulacion::factory()->create();
        $postulacionNueva = Postulacion::with('user', 'partido.user')
            ->findOrFail($postulacionNueva->id);
        $response = $this->actingAs($postulacionNueva->partido->user)->put(route('postulaciones.calificar', [$partido->slug, $postulacion->id]), $request);
        $response->assertStatus(403);
    }
}
