<?php

namespace Creativeorange\LaravelStubs\Console\Publish;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
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

    protected $signature = 'publish:stubs
                                {--f|force : Overwrite any existing files}';

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

        if (!is_dir($stubsPath = $this->laravel->basePath('stubs'))) {
            (new Filesystem)->makeDirectory($stubsPath);
        }

        File::copyDirectory(__DIR__.'/../../stubs/', $stubsPath);

        return $this->info('Stubs published successfully');
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Overwrite any existing files'],
        ];
    }
}