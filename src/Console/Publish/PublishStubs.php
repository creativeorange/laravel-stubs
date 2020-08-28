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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!is_dir($stubsPath = $this->laravel->basePath('stubs'))) {
            (new Filesystem)->makeDirectory($stubsPath);
        }

        $files = File::allFiles(__DIR__.'/../../stubs/');

        foreach ($files as $file) {
            $to = $stubsPath . '/' . $file->getFilename();
            $from = $file->getPathName();
            if (!file_exists($to) || $this->option('force')) {
                file_put_contents($to, file_get_contents($from));
            }
        }

        $this->info('Stubs published successfully');
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Overwrite any existing files'],
        ];
    }
}