<?php

namespace App\Http\Controllers\Postulaciones;

use App\Http\Controllers\Controller;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostulacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, Partido $partido)
    {
        $this->authorize('viewAny', [Postulacion::class, $partido]);

        return Postulacion::where('partido_id', $partido->id)
            ->where('estado', 'Esperando respuesta')
            ->with('user:id,name')
            ->orderBy('created_at', 'ASC')
            ->paginate(10);
    }

    public function obtenerPostulantesAceptados(Partido $partido)
    {
        $this->authorize('verAceptados', [Postulacion::class, $partido]);

        return Postulacion::where('partido_id', $partido->id)
            ->where('estado', 'Aceptado')
            ->with('user')
            ->get();
    }

    public function store(Request $request, Partido $partido)
    {
        $this->authorize('create', [Postulacion::class, $partido]);

        $postulacion = new Postulacion();
        $postulacion->estado = 'Esperando respuesta';
        $postulacion->user()->associate(Auth::id());
        $postulacion->partido()->associate($partido->id);
        $postulacion->save();

        return back()->with('message', 'Postulación enviada');
    }

    public function update(
        Request $request,
        Partido $partido,
        Postulacion $postulacione
    ) {
        $this->authorize('update', [$partido, $postulacione]);

        $postulacione->estado = $request->estado;
        $postulacione->save();

        return back()->with('message', 'Postulación actualizada');
    }

    public function destroy(
        Partido $partido,
        Postulacion $postulacione
    ) {
        $this->authorize('delete', $postulacione);

        $postulacione->delete();

        return back()->with('message', 'Tu postulación fue retirada');
    }
}
