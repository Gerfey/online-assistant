<?php

namespace Gerfey\OnlineAssistant;

use Illuminate\Support\ServiceProvider;

class OnlineAssistantServiceProvider extends ServiceProvider
{
    protected $namespace = 'Gerfey\Http\Controller';

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        }

        parent::boot();
    }

    public function map()
    {
        $this->mapRoutes();
    }

    public function register()
    {
        if(!$this->app->configurationIsCached()){
            $this->mergeConfigFrom(__DIR__ . '/../config/online-assistant.php', 'online-assistant');
        }
        $this->offerPublishing();
    }

    public function offerPublishing()
    {
        if($this->app->runningInConsole()){
            $this->publishes([
                __DIR__ . '/../config/online-assistant.php' => config_path('online-assistant.php'),
            ], 'online-assistant');
        }
    }

    protected function mapRoutes()
    {
        \Route::middleware('api')
            ->prefix('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/Routes/api.php');
    }
}
