<?php

namespace Creativeorange\LaravelStubs\Console\Make;

use Creativeorange\LaravelStubs\Console\CustomGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeTrait extends CustomGeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    protected $signature = 'make:trait
                                {name : The name of the trait}
                                {--b|boot : Create a boot trait}
                                {--a|anonymous : Create a trait to anonymous data}
                                {--u|uuid : Create a trait to generate an uuid field}';

    protected $type = 'Trait';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {

        if ($this->option('boot')) {
            return $this->resolveStubPath('/../stubs/trait-boot.stub');
        }

        if ($this->option('anonymous')) {
            return $this->resolveStubPath('/../stubs/trait-anonymous.stub');
        }

        if ($this->option('uuid')) {
            return $this->resolveStubPath('/../stubs/trait-uuid.stub');
        }

        return $this->resolveStubPath('/../stubs/trait.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {

        return (empty(config('laravel-stubs.make.trait.namespace')))
            ? $rootNamespace
            : config('laravel-stubs.make.trait.namespace');
    }

    protected function getNameInput()
    {

        $name = trim($this->argument('name'));

        $name = Str::endsWith($name, 'Trait')
            ? $name
            : $name . 'Trait';

        return $name;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the trait']
        ];
    }

    protected function getOptions()
    {
        return [
            ['boot', 'b', InputOption::VALUE_NONE, 'Create a boot trait'],
            ['anonymous', 'a', InputOption::VALUE_NONE, 'Create a trait to anonymous data'],
            ['uuid', 'u', InputOption::VALUE_NONE, 'Create a trait to generate an uuid field'],
        ];
    }
}