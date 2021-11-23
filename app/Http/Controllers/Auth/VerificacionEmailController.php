<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificacionEmailController extends Controller
{
    public function avisarVerificacion()
    {
        return Inertia::render('Auth/VerifyEmail');
    }

    public function verificar(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('inicio');
    }

    public function EnviarVerificacion(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
