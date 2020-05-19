<?php

namespace Creativeorange\LaravelStubs\Console\Make;

use Creativeorange\LaravelStubs\Console\CustomGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeInterface extends CustomGeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new interface';

    protected $type = 'Interface';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {

        return $this->resolveStubPath('/stubs/interface.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {

        return (empty(config('laravel-stubs.make.interface.namespace')))
            ? $rootNamespace
            : config('laravel-stubs.make.interface.namespace');
    }

    protected function getNameInput()
    {

        $name = trim($this->argument('name'));

        $name = Str::endsWith($name, 'Interface')
            ? $name
            : $name . 'Interface';

        return $name;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the interface']
        ];
    }
}