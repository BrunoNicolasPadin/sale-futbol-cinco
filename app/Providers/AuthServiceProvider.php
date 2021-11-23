<?php

namespace App\Providers;

use App\Models\Partidos\CalificacionPartido;
use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Policies\Partidos\CalificacionPolicy;
use App\Policies\Partidos\PartidoPolicy;
use App\Policies\Postulaciones\PostulacionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        CalificacionPartido::class => CalificacionPolicy::class,
        Partido::class => PartidoPolicy::class,
        Postulacion::class => PostulacionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
