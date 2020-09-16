<?php

namespace Creativeorange\LaravelStubs;

use Creativeorange\LaravelStubs\Console;
use Illuminate\Support\ServiceProvider;

class LaravelStubsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                /** Create */
                Console\Create\CreateUser::class,
                /** Dispatch */
                Console\Dispatch\DispatchJob::class,
                /** Make */
                Console\Make\MakeTrait::class,
                Console\Make\MakeScope::class,
                Console\Make\MakeInterface::class,
                Console\Make\MakeViewComposer::class,
                Console\Make\MakeFacade::class,
                Console\Make\MakeHelper::class,
                Console\Make\MakeResponse::class,
                /** Patch */
                Console\Patch::class,
                /** Publish */
                Console\Publish\PublishConfig::class,
                Console\Publish\PublishStubs::class,
                /** Run */
                Console\Run\RunFactory::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/Config/laravel-stubs.php' => base_path('config/laravel-stubs.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/laravel-stubs.php', 'laravel-stubs');

        foreach (glob(app_path() . '/' . \config('laravel-stubs.make.helper.folder') . '/*.php') as $file) {
            require_once($file);
        }
    }
}