<?php

namespace MetaverseSystems\ClarionPHPBackend;

use Illuminate\Support\ServiceProvider;
use MetaverseSystems\ClarionPHPBackend\Commands\SetupClarion;
use MetaverseSystems\ClarionPHPBackend\Commands\BuildFrontend;
use MetaverseSystems\ClarionPHPBackend\Commands\BuildReactRoutes;
use MetaverseSystems\ClarionPHPBackend\Commands\BuildReactLinks;
use MetaverseSystems\ClarionPHPBackend\Commands\InstallComposerPackage;
use MetaverseSystems\ClarionPHPBackend\Commands\InstallNPMPackage;

class ClarionPHPBackendProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            SetupClarion::class,
            BuildFrontend::class,
            BuildReactRoutes::class,
            BuildReactlinks::class,
            InstallComposerPackage::class,
            InstallNPMPackage::class
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'clarion');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        $this->publishes([
            __DIR__.'/files' => base_path(),
        ]);

        if(!$this->app->routesAreCached())
        {
            require __DIR__.'/Routes.php';
        }

        \App::booted(function() {
            app('router')->get('/', function() { return view("clarion::index"); })->middleware('web');
            app('router')->get('/{any}', function() { return view("clarion::index"); })->middleware('web')->where('any', '^.*$');
        });
    }
}
