<?php

namespace Creativeorange\LaravelStubs\Console\Make;

use Creativeorange\LaravelStubs\Console\CustomGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeScope extends CustomGeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:scope';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new scope';

    protected $signature = 'make:scope
                                {name : The name of the scope}';

    protected $type = 'Scope';

    protected function getStub()
    {
        return $this->resolveStubPath('/../stubs/scope.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return (empty(config('laravel-stubs.make.scope.namespace')))
            ? $rootNamespace
            : config('laravel-stubs.make.scope.namespace');
    }

    protected function getNameInput()
    {
        $name = trim($this->argument('name'));

        $name = Str::endsWith($name, 'Scope')
            ? $name
            : $name . 'Scope';

        return $name;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the scope']
        ];
    }
}