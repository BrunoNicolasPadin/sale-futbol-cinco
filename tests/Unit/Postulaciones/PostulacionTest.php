<?php

namespace Tests\Unit\Postulaciones;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use Tests\TestCase;

class PostulacionTest extends TestCase
{
    public function test_no_permitir_postulaciones_en_partidos_que_no_buscan_jugadores()
    {
        $user = User::factory()->create();
        $partido =  Partido::factory()->create();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->post(route('postulaciones.store', $partido->slug));
        $response->assertRedirect(route('partidos.show', $partido->slug));

        $segundoUser = User::factory()->create();
        $partidoFinalizado =  Partido::factory()->create([
            'estado' => "Busqueda finalizada",
        ]);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $segundoUser */
        $response = $this->actingAs($segundoUser)->post(route('postulaciones.store', $partidoFinalizado->slug));
        $response->assertStatus(403);
    }

    public function test_no_permitir_postularse_al_creador_del_partido()
    {
        $partido =  Partido::factory()->create();

        $response = $this->actingAs($partido->user)->post(route('postulaciones.store', $partido->slug));
        $response->assertStatus(403);
    }

    public function test_solo_el_creador_pueda_ver_los_postulantes()
    {
        $partido =  Partido::factory()->create()->with('user')->first();

        $response = $this->actingAs($partido->user)->get(route('postulaciones.index', $partido->slug));
        $response->assertStatus(200);

        $userNoCreador = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userNoCreador */
        $response = $this->actingAs($userNoCreador)->get(route('postulaciones.index', $partido->slug));
        $response->assertStatus(403);
    }

    public function test_solo_el_creador_pueda_ver_los_postulantes_aceptados()
    {
        $partido =  Partido::factory()->create()->with('user')->first();

        $response = $this->actingAs($partido->user)->get(route('postulaciones.aceptados', $partido->slug));
        $response->assertStatus(200);

        $userNoCreador = User::factory()->create();
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userNoCreador */
        $response = $this->actingAs($userNoCreador)->get(route('postulaciones.aceptados', $partido->slug));
        $response->assertStatus(403);
    }

    public function test_solo_el_mismo_jugador_puede_eliminar_su_postulacion()
    {
        $partido =  Partido::factory()->create()->with('user')->first();
        $postulacion = Postulacion::factory()->create([
            'partido_id' => $partido->id,
        ])->with('user')->first();

        $response = $this->actingAs($partido->user)->delete(route('postulaciones.destroy', [$partido->slug, $postulacion->id]));
        $response->assertStatus(403);

        $response = $this->actingAs($postulacion->user)->delete(route('postulaciones.destroy', [$partido->slug, $postulacion->id]));
        $response->assertRedirect(route('partidos.show', $partido->slug));
    }

    public function test_solo_el_creador_puede_cambiar_el_estado_de_las_postulaciones()
    {
        $partido =  Partido::factory()->create()->with('user')->first();

        $postulacion = Postulacion::factory()->create([
            'partido_id' => $partido->id,
        ])->with('user')->first();

        $request = [];
        $request['estado'] = 'Esperando respuesta';

        $response = $this->actingAs($partido->user)->put(route('postulaciones.update', [$partido->slug, $postulacion->id]), $request);
        $response->assertStatus(302);

        $request['estado'] = 'Aceptado';
        $response = $this->actingAs($postulacion->user)->put(route('postulaciones.update', [$partido->slug, $postulacion->id]), $request);
        $response->assertStatus(403);
    }
}
