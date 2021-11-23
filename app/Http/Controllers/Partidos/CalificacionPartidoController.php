<?php

namespace App\Http\Controllers\Partidos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Postulaciones\CalificacionRequest;
use App\Models\Partidos\CalificacionPartido;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Models\User;
use App\Notifications\Partidos\PartidoCalificado;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CalificacionPartidoController extends Controller
{
    public function index(Partido $partido)
    {
        $postulacion = null;
        $user_id = null;
        $calificacionDelPostulado = false;
        if (Auth::check()) {
            $postulacion = $this->obtenerPostulacion($partido);
            $user_id = Auth::id();
            $calificacionDelPostulado =
                $this->verificarExistenciaDeLaCalificacion(
                    $partido,
                    $user_id
                );
        }
        return Inertia::render('Calificaciones/Index', [
            'partido' => $partido,
            'postulacion' => $postulacion,
            'user_id' => $user_id,
            'calificacionDelPostulado' => $calificacionDelPostulado,
            'calificaciones' => CalificacionPartido::where(
                'partido_id',
                $partido->id
            )->with('user')->orderBy('created_at', 'ASC')->get(),
        ]);
    }

    public function obtenerPostulacion($partido)
    {
        return Postulacion::where(
            'partido_id',
            $partido->id
        )
            ->where('user_id', Auth::id())
            ->where('estado', 'Aceptado')
            ->first();
    }

    public function verificarExistenciaDeLaCalificacion(
        $partido,
        $user_id
    ) {
        if (CalificacionPartido::where(
            'partido_id',
            $partido->id
        )
            ->where('user_id', $user_id)
            ->exists()) {
            return true;
        }
        return false;
    }

    public function store(
        CalificacionRequest $request,
        Partido $partido
    ) {
        $this->authorize('create', [
            CalificacionPartido::class,
            $partido,
        ]);

        $calificacionPartido = new CalificacionPartido();
        $calificacionPartido->partido()->associate($partido->id);
        $calificacionPartido->user()->associate(Auth::id());
        $calificacionPartido->puntaje = $request->puntaje;
        $calificacionPartido->comentario = $request->comentario;
        $calificacionPartido->save();

        $user = User::findOrFail($partido->user_id);
        $user->notify(new PartidoCalificado($partido));

        return redirect(route('calificaciones.index', $partido->slug))
            ->with('message', 'Calificación enviada');
    }

    public function update(
        CalificacionRequest $request,
        Partido $partido,
        CalificacionPartido $calificacione
    ) {
        $this->authorize('verificarQueCoincidaElUsuario', $calificacione);

        $calificacione->puntaje = $request->puntaje;
        $calificacione->comentario = $request->comentario;
        $calificacione->save();

        return redirect(route('calificaciones.index', $partido->slug))
            ->with('message', 'Calificación actualizada');
    }

    public function destroy(
        Partido $partido,
        CalificacionPartido $calificacione
    ) {
        $this->authorize('verificarQueCoincidaElUsuario', $calificacione);

        $calificacione->delete();
        return redirect(route('calificaciones.index', $partido->slug))
            ->with('message', 'Tu calificación fue eliminada');
    }
}
