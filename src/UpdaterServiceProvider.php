<?php

namespace Project;

use Illuminate\Support\ServiceProvider;

class UpdaterServiceProvider extends ServiceProvider{

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CheckForUpdate::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'updater');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/updater'),
            __DIR__.'/../config/updater.php' => config_path('updater.php'),
        ]);

    }
} 