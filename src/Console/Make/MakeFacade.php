<?php

namespace Creativeorange\LaravelStubs\Console\Make;

use Creativeorange\LaravelStubs\Console\CustomGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeFacade extends CustomGeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:facade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new facade';

    protected $signature = 'make:facade
                                {name : The name of the facade}
                                {accessor : The accessor for the facade}';

    protected $type = 'Facade';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {

        return $this->resolveStubPath('/../stubs/facade.stub');
    }

    protected function replaceNamespace(&$stub, $name)
    {
        $this->parseAccessor($stub);

        return parent::replaceNamespace($stub, $name);
    }

    protected function parseAccessor(&$stub)
    {

        $accessor = $this->argument('accessor');
        $accessor = Str::endsWith($accessor, '/')
            ? $accessor
            : '/' . $accessor;

        $accessor = \str_replace('/', '\\', $accessor);

        $stub = \str_replace('DummyAccessor', $accessor, $stub);
    }

    protected function getDefaultNamespace($rootNamespace)
    {

        return (empty(config('laravel-stubs.make.facade.namespace')))
            ? $rootNamespace
            : config('laravel-stubs.make.facade.namespace');
    }

    protected function getNameInput()
    {

        $name = trim($this->argument('name'));

        $name = Str::endsWith($name, 'Facade')
            ? $name
            : $name . 'Facade';

        return $name;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the facade'],
            ['accessor', InputArgument::REQUIRED, 'The accessor for the facade']
        ];
    }
}