<?php

namespace Creativeorange\LaravelStubs\Console\Make;

use Creativeorange\LaravelStubs\Console\CustomGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeResponse extends CustomGeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:response';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new response';

    protected $signature = 'make:response
                                {name : The name of the response}';

    protected $type = 'Response';

    protected function getStub()
    {
        return $this->resolveStubPath('/../stubs/response.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return (empty(config('laravel-stubs.make.response.namespace')))
            ? $rootNamespace
            : config('laravel-stubs.make.response.namespace');
    }

    protected function getNameInput()
    {
        $name = trim($this->argument('name'));

        $name = Str::endsWith($name, 'Response')
            ? $name
            : $name . 'Response';

        return $name;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the response']
        ];
    }
}