<?php

namespace Creativeorange\LaravelStubs\Console\Make;

use Creativeorange\LaravelStubs\Console\CustomGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeHelper extends CustomGeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:helper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new helper';

    protected $signature = 'make:helper
                                {name : The name of the helper}';

    protected $type = 'Helper';

    protected function getStub()
    {
        return $this->resolveStubPath('/../stubs/helper.stub');
    }

    protected function replaceNamespace(&$stub, $name)
    {
        $this->parseFunctionName($stub);

        return parent::replaceNamespace($stub, $name);
    }

    protected function parseFunctionName(&$stub)
    {
        $functionName = $this->getNameInput();
        $functionName = \preg_replace('/helper$/i', '', $functionName);
        $functionName = Str::snake($functionName);

        $stub = \str_replace('DummyFunction', $functionName, $stub);
    }

    public function handle()
    {
        $name = $this->getNameInput();

        $path = $this->getPath($name);

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $this->info($this->type.' created successfully.');
    }

    protected function getPath($name)
    {
        return $this->laravel['path'].'/'.config('laravel-stubs.make.helper.folder').'/'.str_replace('\\', '/', $name).'.php';
    }

    protected function getNameInput()
    {
        $name = trim($this->argument('name'));

        $name = Str::endsWith($name, 'Helper')
            ? $name
            : $name . 'Helper';

        return $name;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the helper']
        ];
    }
}