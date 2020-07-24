<?php

namespace Creativeorange\LaravelStubs\Console\Make;

use Creativeorange\LaravelStubs\Console\CustomGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeViewComposer extends CustomGeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:view:composer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view composer';

    protected $signature = 'make:view:composer
                                {name : The name of the view composer}';

    protected $type = 'View composer';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {

        return $this->resolveStubPath('/../stubs/view-composer.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {

        return (empty(config('laravel-stubs.make.view:composer.namespace')))
            ? $rootNamespace
            : config('laravel-stubs.make.view:composer.namespace');
    }

    protected function getNameInput()
    {

        $name = trim($this->argument('name'));

        $name = Str::endsWith($name, 'Composer')
            ? $name
            : $name . 'Composer';

        return $name;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the view composer']
        ];
    }
}