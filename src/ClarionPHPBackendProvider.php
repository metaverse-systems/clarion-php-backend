<?php

namespace MetaverseSystems\ClarionPHPBackend;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use MetaverseSystems\ClarionPHPBackend\Commands\SetupClarion;
use MetaverseSystems\ClarionPHPBackend\Commands\MigrateClarion;
use MetaverseSystems\ClarionPHPBackend\Commands\BuildFrontend;
use MetaverseSystems\ClarionPHPBackend\Commands\BuildReactRoutes;
use MetaverseSystems\ClarionPHPBackend\Commands\BuildReactLinks;
use MetaverseSystems\ClarionPHPBackend\Commands\InstallComposerPackage;
use MetaverseSystems\ClarionPHPBackend\Commands\InstallNPMPackage;
use MetaverseSystems\ClarionPHPBackend\Commands\SyncStoreApps;
use MetaverseSystems\ClarionPHPBackend\Commands\WatchPackageQueue;
use MetaverseSystems\ClarionPHPBackend\Commands\SetupCron;

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
            MigrateClarion::class,
            BuildFrontend::class,
            BuildReactRoutes::class,
            BuildReactlinks::class,
            InstallComposerPackage::class,
            InstallNPMPackage::class,
            SyncStoreApps::class,
            WatchPackageQueue::class,
            SetupCron::class
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

            $conns = config('broadcasting.connections');
            $conns['clarion_pusher'] = [
                'driver' => 'pusher',
                'key' => env('PUSHER_APP_KEY'),
                'secret' => env('PUSHER_APP_SECRET'),
                'app_id' => env('PUSHER_APP_ID'),
                'options' => [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => false,
                    'host' => '0.0.0.0',
                    'port' => 6001,
                    'scheme' => 'http'
                ]
            ];
            config(['broadcasting.connections' => $conns]);
        });

        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command('clarion:migrate')->everyMinute();
            $schedule->command('clarion:watch-package-queue')->everyMinute();
            $schedule->command('clarion:apps-sync')->hourly();
        });
    }
}
