<?php

namespace App\Http\Controllers\Postulaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Postulaciones\CalificacionRequest;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Services\Calificaciones\CalificacionPostulacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostulacionController extends Controller
{
    protected $calificacionPostulacionService;

    public function __construct(
        CalificacionPostulacionService $calificacionPostulacionService
    ) {
        $this->middleware('auth');
        $this->calificacionPostulacionService = $calificacionPostulacionService;
    }

    public function index($slug)
    {
        $partido = Partido::where('slug', $slug)->first();
        $this->authorize('viewAny', [Postulacion::class, $partido]);

        return $this->calificacionPostulacionService
            ->obtenerCalificaciones($partido->id, 'Esperando respuesta');
    }

    public function obtenerPostulantesAceptados($slug)
    {
        $partido = Partido::where('slug', $slug)->first();
        $this->authorize('verAceptados', [Postulacion::class, $partido]);

        return $this->calificacionPostulacionService
            ->obtenerCalificaciones($partido->id, 'Aceptado');
    }

    public function store(Request $request, $slug)
    {
        $partido = Partido::where('slug', $slug)->first();
        $this->authorize('create', [Postulacion::class, $partido]);

        $postulacion = new Postulacion();
        $postulacion->estado = 'Esperando respuesta';
        $postulacion->user()->associate(Auth::id());
        $postulacion->partido()->associate($partido->id);
        $postulacion->save();

        return redirect(route('partidos.show', $slug))
            ->with('message', 'Tu postulación fue cargada');
    }

    public function update(
        Request $request,
        Partido $partido,
        Postulacion $postulacione
    ) {
        $this->authorize('update', $partido);

        $postulacione->estado = $request->estado;
        $postulacione->save();

        return redirect(route('partidos.show', $partido->slug))
            ->with('message', 'Postulación actualizada');
    }

    public function destroy(
        Partido $partido,
        Postulacion $postulacione
    ) {
        $this->authorize('delete', $postulacione);

        $postulacione->delete();

        return redirect(route('partidos.show', $partido->slug))
            ->with('message', 'Tu postulación fue retirada');
    }

    //Mostrar la postulación de un solo jugador para calificarla
    //o solo ver su calificación
    public function show(Partido $partido, $id)
    {
        $postulacion = Postulacion::with('user')
            ->findOrFail($id);

        $this->authorize('view', [$postulacion, $partido]);

        return Inertia::render('Postulaciones/Show', [
            'partido' => $partido,
            'postulacion' => $postulacion,
            'user_id' => Auth::id(),
        ]);
    }

    public function calificarPostulacion(
        CalificacionRequest $request,
        Partido $partido,
        $id
    ) {
        $this->authorize('calificarPostulacion', [
            Postulacion::class,
            $partido,
        ]);

        $postulacion = Postulacion::findOrFail($id);
        $postulacion->puntaje = $request->puntaje;
        $postulacion->comentario = $request->comentario;
        $postulacion->save();

        return redirect(route('postulaciones.show', [
            $partido->slug,
            $postulacion->id,
        ]))->with('message', 'Calificación enviada');
    }

    public function eliminarCalificacion(
        Partido $partido,
        $id
    ) {
        $this->authorize('eliminarCalificacion', [
            Postulacion::class,
            $partido,
        ]);

        $postulacion = Postulacion::findOrFail($id);
        $postulacion->puntaje = null;
        $postulacion->comentario = null;
        $postulacion->save();

        return redirect(route('postulaciones.show', [
            $partido->slug,
            $postulacion->id,
        ]))->with('message', 'Calificación eliminada');
    }
}
