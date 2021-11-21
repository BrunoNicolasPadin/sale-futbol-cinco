<?php

namespace Tests\Unit\Partidos;

use App\Models\Partidos\Partido;
use App\Models\User;
use Tests\TestCase;

class PartidoTest extends TestCase
{
    public function test_solo_el_creador_del_partido_puede_editarlo()
    {
        $this->withoutMiddleware();

        $partido = Partido::factory()->create();
        $partido->with('user')->first();

        $user =  User::factory()->create();

        $response = $this->actingAs($partido->user)->get(route('partidos.edit', $partido->slug));
        $response->assertStatus(200);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->get(route('partidos.edit', $partido->slug));
        $response->assertStatus(403);
    }

    public function test_solo_el_creador_del_partido_puede_eliminarlo()
    {
        $this->withoutMiddleware();

        $partido = Partido::factory()->create();
        $partido->with('user')->first();

        $partidoNoElimiable = Partido::factory()->create();

        $user =  User::factory()->create();

        $response = $this->actingAs($partido->user)->delete(route('partidos.destroy', $partido->slug));
        $response->assertRedirect(route('partidos.index'));

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $response = $this->actingAs($user)->delete(route('partidos.destroy', $partidoNoElimiable->slug));
        $response->assertStatus(403);
    }
}
