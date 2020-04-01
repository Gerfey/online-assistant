<?php

namespace App\Services\Answer;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class AnswerServicesProvider extends ServiceProvider
{
    protected $namespace = 'App\Services\Answer\Http\Controller';

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

    /**
     * @return void
     */
    protected function mapRoutes()
    {
        \Route::middleware('api')
            ->prefix('api')
            ->namespace($this->namespace)
            ->group(base_path('app/Services/Answer/Routes/api.php'));
    }
}
