<?php

namespace Creativeorange\LaravelStubs;

use Creativeorange\LaravelStubs\Console;
use Illuminate\Support\ServiceProvider;

class LaravelStubsServiceProvider extends ServiceProvider
{

    public function boot() {

        if ($this->app->runningInConsole()) {
            $this->commands([
                /** Create */
                Console\Create\CreateUser::class,
                /** Make */
                Console\Make\MakeTrait::class,
                Console\Make\MakeInterface::class,
                /** Publish */
                Console\Publish\PubishStubs::class,
                /** Run */
                Console\Run\RunFactory::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/Config/laravel-stub.php' => base_path('config/laravel-stub.php')
        ], 'config');
    }

    public function register() {


        $this->mergeConfigFrom(__DIR__ . '/Config/laravel-stub.php', 'laravel-stub');
    }
}