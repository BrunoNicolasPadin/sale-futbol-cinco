<?php

namespace Tests\Unit;

use App\Models\Partidos\CalificacionPartido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use Tests\TestCase;

class CalificacionTest extends TestCase
{
    public function test_solo_los_postulados_aceptados_pueden_calificar()
    {
        $postulacion = Postulacion::factory()->create([
            'estado' => 'Aceptado',
        ]);
        $postulacion = Postulacion::with('user', 'partido')
            ->findOrFail($postulacion->id);

        $request = [];
        $request['puntaje'] = 1;
        $request['comentario'] = null;

        //Postulante aceptado enviando su calificacion
        $response = $this->actingAs($postulacion->user)
            ->post(route('calificaciones.store', $postulacion->partido->slug), $request);
        $response->assertRedirect(route('calificaciones.index', $postulacion->partido->slug));

        //Postulante no aceptado queriendo enviar su calificacion
        $postulacionNoAceptada = Postulacion::factory()->create();
        $postulacionNoAceptada = Postulacion::with('user', 'partido')
            ->findOrFail($postulacionNoAceptada->id);
        $response = $this->actingAs($postulacionNoAceptada->user)
            ->post(route('calificaciones.store', $postulacionNoAceptada->partido->slug), $request);
        $response->assertStatus(403);
    }

    public function test_solo_el_mismo_usuario_pueden_editar_su_calificacion()
    {
        $calificacionPartido = CalificacionPartido::factory()->create();
        $calificacionPartido = CalificacionPartido::with('user', 'partido')
            ->findOrFail($calificacionPartido->id);

        $request = [];
        $request['puntaje'] = 1;
        $request['comentario'] = null;

        //Postulante editando su propia calificacion
        $response = $this->actingAs($calificacionPartido->user)
            ->put(route('calificaciones.update', [$calificacionPartido->partido->slug, $calificacionPartido->id]), $request);
        $response->assertRedirect(route('calificaciones.index', $calificacionPartido->partido->slug));

        //Postulante queriendo editar la calificacion de otro usuario
        $usuario = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $usuario */
        $response = $this->actingAs($usuario)
            ->put(route('calificaciones.update', [$calificacionPartido->partido->slug, $calificacionPartido->id]), $request);
        $response->assertStatus(403);
    }

    public function test_solo_el_mismo_usuario_pueden_eliminar_su_calificacion()
    {
        $calificacionPartido = CalificacionPartido::factory()->create();
        $calificacionPartido = CalificacionPartido::with('user', 'partido')
            ->findOrFail($calificacionPartido->id);

        //Postulante queriendo eliminar la calificacion de otro usuario
        $usuario = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $usuario */
        $response = $this->actingAs($usuario)
            ->delete(route('calificaciones.destroy', [$calificacionPartido->partido->slug, $calificacionPartido->id]));
        $response->assertStatus(403);

        //Postulante eliminando su propia calificacion
        $response = $this->actingAs($calificacionPartido->user)
            ->delete(route('calificaciones.destroy', [$calificacionPartido->partido->slug, $calificacionPartido->id]));
        $response->assertRedirect(route('calificaciones.index', $calificacionPartido->partido->slug));
    }

    public function test_solo_se_puede_hacer_una_calificacion()
    {
        $postulacion = Postulacion::factory()->create([
            'estado' => 'Aceptado',
        ]);
        $postulacion = Postulacion::with('user', 'partido')
            ->findOrFail($postulacion->id);

        $request = [];
        $request['puntaje'] = 1;
        $request['comentario'] = null;

        //Postulante aceptado enviando su calificacion
        $response = $this->actingAs($postulacion->user)
            ->post(route('calificaciones.store', $postulacion->partido->slug), $request);
        $response->assertRedirect(route('calificaciones.index', $postulacion->partido->slug));

        //Postulante aceptado queriendo enviar otra calificacion
        $response = $this->actingAs($postulacion->user)
            ->post(route('calificaciones.store', $postulacion->partido->slug), $request);
        $response->assertStatus(403);
    }
}
