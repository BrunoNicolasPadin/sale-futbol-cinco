<?php

namespace App\Http\Controllers\Postulaciones;

use App\Http\Controllers\Controller;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostulacionController extends Controller
{
    public function index(Request $request, Partido $partido)
    {
        return Postulacion::where('partido_id', $partido->id)
            ->where('estado', 'Esperando respuesta')
            ->with('user:id,name')
            ->orderBy('created_at', 'ASC')
            ->paginate(10);
    }

    public function obtenerPostulantesAceptados(Partido $partido)
    {
        return Postulacion::where('partido_id', $partido->id)
            ->where('estado', 'Aceptado')
            ->with('user')
            ->get();
    }

    public function store(Request $request, $partido_id)
    {
        $postulacion = new Postulacion();
        $postulacion->estado = 'Esperando respuesta';
        $postulacion->user()->associate(Auth::id());
        $postulacion->partido()->associate($partido_id);
        $postulacion->save();

        return back()->with('message', 'Postulación enviada');
    }

    public function update(Request $request, Partido $partido, Postulacion $postulacione)
    {
        $postulacione->estado = $request->estado;
        $postulacione->save();

        return back()->with('message', 'Postulación actualizada');
    }

    public function show($partido_id, Postulacion $postulacione)
    {
        //
    }

    public function destroy($partido_id, Postulacion $postulacione)
    {
        $postulacione->delete();

        return back()->with('message', 'Tu postulación fue retirada');
    }
}
