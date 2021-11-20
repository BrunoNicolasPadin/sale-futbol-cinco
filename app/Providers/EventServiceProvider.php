<?php

namespace App\Providers;

use App\Models\Partidos\Partido;
use App\Models\Postulaciones\Postulacion;
use App\Observers\Partidos\PartidoObserver;
use App\Observers\Postulaciones\PostulacionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Partido::observe(PartidoObserver::class);
        Postulacion::observe(PostulacionObserver::class);
    }
}
