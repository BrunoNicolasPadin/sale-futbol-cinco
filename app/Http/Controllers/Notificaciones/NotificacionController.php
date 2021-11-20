<?php

namespace App\Http\Controllers\Notificaciones;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificacionController extends Controller
{
    public function listar()
    {
        $user = User::findOrFail(Auth::id());

        return Inertia::render('Notificaciones/Index', [
            'notificaciones' => $user->unreadNotifications,
        ]);
    }

    public function marcarComoLeida($notificacion_id)
    {
        $user = User::findOrFail(Auth::id());
        $user->unreadNotifications()->where('id', $notificacion_id)->update(['read_at' => now()]);
        return back()->with('message', 'Notificación marcada como leída');
    }

    public function marcarTodasComoLeidas()
    {
        $user = User::findOrFail(Auth::id());
        $user->unreadNotifications->markAsRead();
    }

    public function contarNotificacionesSinLeer()
    {
        return auth()->user()->notifications->count();
    }
}
