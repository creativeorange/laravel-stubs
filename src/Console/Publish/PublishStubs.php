<?php

namespace Creativeorange\LaravelStubs\Console\Publish;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class PublishStubs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'publish:stubs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the stubs of this package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if (! is_dir($stubsPath = $this->laravel->basePath('stubs'))) {
            (new Filesystem)->makeDirectory($stubsPath);
        }

        $files = [
            __DIR__.'/../../stubs/interface.stub' => $stubsPath.'/interface.stub',
            __DIR__.'/../../stubs/trait.stub' => $stubsPath.'/trait.stub',
            __DIR__.'/../../stubs/trait-boot.stub' => $stubsPath.'/trait-boot.stub',
        ];

        foreach ($files as $from => $to) {
            if (! file_exists($to) || $this->option('force')) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        return $this->info('Stubs published successfully.');
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Overwrite any existing files'],
        ];
    }
}