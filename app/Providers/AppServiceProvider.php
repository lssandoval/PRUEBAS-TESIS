<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureProxies();
    }

    /**
     * Configura los proxies confiables.
     *
     * @return void
     */
    protected function configureProxies()
    {
        // Especifica los proxies confiables, puedes usar IPs o patrones
        Request::setTrustedProxies(
            ['*'], // Puedes especificar IPs de proxies confiables aquí
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO
        );
    }
}
