<?php

namespace Creativeorange\LaravelStubs\Console\Publish;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class PublishConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'publish:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the config of this package';

    protected $signature = 'publish:config
                                {--f|force : Overwrite any existing files}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $to = $this->laravel->basePath('config/laravel-stubs.php');
        if (!file_exists($to) || $this->option('force')) {
            file_put_contents($to, file_get_contents(__DIR__.'/../../Config/laravel-stubs.php'));
        }

        $this->info('Config published successfully');
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Overwrite any existing files'],
        ];
    }
}