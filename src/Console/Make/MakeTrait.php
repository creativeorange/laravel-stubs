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

    protected $type = 'Trait';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {

        return $this->option('boot')
            ? $this->resolveStubPath('/stubs/trait-boot.stub')
            : $this->resolveStubPath('/stubs/trait.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {

        return $rootNamespace . '\Traits';
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
            ['boot', 'b', InputOption::VALUE_NONE, 'Create a boot trait.'],
        ];
    }
}