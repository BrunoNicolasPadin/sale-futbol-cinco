<?php

namespace App\Http\Controllers\Partidos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partidos\StorePartidoRequest;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Services\Calificaciones\CalificacionPartidoService;
use App\Services\Slugs\SlugService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PartidoController extends Controller
{
    protected $slugService;

    public function __construct(
        SlugService $slugService,
        CalificacionPartidoService $calificacionPartidoService
    ) {
        $this->slugService = $slugService;
        $this->calificacionPartidoService = $calificacionPartidoService;
        $this->middleware('auth')->except(
            'index',
            'show',
            'filtrarPartidos'
        );
    }

    public function index(Request $request)
    {
        return Inertia::render('Partidos/Index', [
            'partidos' => $this->filtrarPartidos($request),
        ]);
    }

    public function filtrarPartidos(Request $request)
    {
        return Partido::with('user')
            ->filtrar($request)
            ->where('estado', 'Buscando jugadores')
            ->orderBy('nombre')
            ->paginate(20)
            ->through(function ($partido) {
                return [
                    'id' => $partido->id,
                    'nombre' => $partido->nombre,
                    'slug' => $partido->slug,
                    'lugar' => $partido->lugar,
                    'cuantosFaltan' => $partido->cuantosFaltan,
                    'precio' => $partido->precio,
                    'tipoDeCancha' => $partido->tipoDeCancha,
                    'fechaHoraFinalizacion' => Carbon::parse(
                        $partido->fechaHoraFinalizacion
                    )->format('d/m/y - H:i:s'),
                    'user' => $partido->user,
                ];
            });
    }

    public function create()
    {
        return Inertia::render('Partidos/Create');
    }

    public function store(StorePartidoRequest $request)
    {
        $request = $this->cambiarFechaParaGuardarCorrectamente(
            $request
        );

        $partido = new Partido();
        $partido->nombre = $request->nombre;
        $partido->slug = $this->slugService->obtenerSlug(
            $request->nombre
        );
        $partido->detalles = $request->detalles;
        $partido->fechaHoraFinalizacion = $request->fechaHoraFinalizacion;
        $partido->lugar = $request->lugar;
        $partido->cuantosFaltan = $request->cuantosFaltan;
        $partido->precio = $request->precio;
        $partido->tipoDeCancha = $request->tipoDeCancha;
        $partido->estado = $request->estado;
        $partido->user()->associate(Auth::id());
        $partido->save();

        return redirect(route('partidos.show', $partido->slug))
            ->with('message', 'Partido publicado');
    }

    public function show(Partido $partido)
    {
        $user_id = null;
        $presentoPostulacion = null;
        $postulacion = null;

        if (Auth::check()) {
            $user_id = Auth::id();

            $presentoPostulacion = Postulacion::where(
                'partido_id', $partido->id
            )->where('user_id', $user_id)->exists();

            if ($presentoPostulacion) {
                $postulacion = Postulacion::where(
                    'partido_id',
                    $partido->id
                )->where('user_id', $user_id)->first();
            }
        }

        return Inertia::render('Partidos/Show', [
            'partido' => [
                'id' => $partido->id,
                'user_id' => $partido->user_id,
                'nombre' => $partido->nombre,
                'slug' => $partido->slug,
                'lugar' => $partido->lugar,
                'cuantosFaltan' => $partido->cuantosFaltan,
                'precio' => $partido->precio,
                'estado' => $partido->estado,
                'detalles' => $partido->detalles,
                'tipoDeCancha' => $partido->tipoDeCancha,
                'fechaHoraFinalizacion' => Carbon::parse(
                    $partido->fechaHoraFinalizacion
                )->format('d/m/Y - H:i:s'),
            ],
            'user_id' => $user_id,
            'presentoPostulacion' => $presentoPostulacion,
            'postulacion' => $postulacion,
            'calificacion' => $this->calificacionPartidoService
                ->obtenerCalificaciones($partido->id),
        ]);
    }

    public function edit($slug)
    {
        $partido = Partido::where('slug', $slug)->first();
        $this->authorize('update', $partido);

        return Inertia::render('Partidos/Edit', [
            'partido' => [
                'id' => $partido->id,
                'user_id' => $partido->user_id,
                'nombre' => $partido->nombre,
                'slug' => $partido->slug,
                'lugar' => $partido->lugar,
                'cuantosFaltan' => $partido->cuantosFaltan,
                'precio' => $partido->precio,
                'estado' => $partido->estado,
                'detalles' => $partido->detalles,
                'tipoDeCancha' => $partido->tipoDeCancha,
                'fechaHoraFinalizacion' => Carbon::parse(
                    $partido->fechaHoraFinalizacion
                )->format('d-m-Y H:i:s'),
            ],
        ]);
    }

    public function update(Request $request, Partido $partido)
    {
        $this->authorize('update', $partido);

        $request = $this->cambiarFechaParaGuardarCorrectamente(
            $request
        );

        $partido->nombre = $request->nombre;
        $partido->detalles = $request->detalles;
        $partido->fechaHoraFinalizacion = $request->fechaHoraFinalizacion;
        $partido->lugar = $request->lugar;
        $partido->cuantosFaltan = $request->cuantosFaltan;
        $partido->precio = $request->precio;
        $partido->tipoDeCancha = $request->tipoDeCancha;
        $partido->estado = $request->estado;
        $partido->save();

        return redirect(route('partidos.show', $partido->slug))
            ->with('message', 'Partido actualizado');
    }

    public function destroy($slug)
    {
        $partido = Partido::where('slug', $slug)->first();
        $this->authorize('delete', $partido);

        $partido->delete();
        return redirect(route('partidos.index'))
            ->with('message', 'Partido eliminado');
    }

    public function cambiarFechaParaGuardarCorrectamente($request)
    {
        $fechaHoraFinalizacion = Carbon::parse(
            $request->fechaHoraFinalizacion
        )->format('Y-m-d H:i:s');

        $request->merge([
            'fechaHoraFinalizacion' => $fechaHoraFinalizacion,
        ]);

        return $request;
    }
}
