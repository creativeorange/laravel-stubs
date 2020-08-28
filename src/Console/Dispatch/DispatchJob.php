<?php

namespace Creativeorange\LaravelStubs\Console\Dispatch;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class DispatchJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'dispatch:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a job';

    protected $signature = 'dispatch:job
                                {job : The job class to dispatch}
                                {arguments?* : Add arguments to the job}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $class = trim($this->argument('job'));
        $class = \str_replace('/', '\\', $class);

        if (!\class_exists($class)) {
            return $this->error('Job does not exist');
        }

        dispatch(new $class(...$this->argument('arguments')));

        $this->info('Successfully dispatched job');
    }

    protected function getArguments()
    {
        return [
            ['job', InputArgument::REQUIRED, 'The job class to dispatch'],
            ['arguments', InputArgument::IS_ARRAY, 'Add arguments to the job'],
        ];
    }
}
