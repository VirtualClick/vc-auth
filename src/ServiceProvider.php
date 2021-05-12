<?php

namespace VirtualClickAuth;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            $this->caminhaConfigPacote(), 'vcauth'
        );
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            $this->caminhaConfigPacote() => config_path('vcauth.php'),
        ]);
    }

    /**
     * Caminho para arquivo de configuracao do pacote
     *
     * @return string
     */
    protected function caminhaConfigPacote()
    {

        return __DIR__ . '/../config/vcauth.php';
    }
}