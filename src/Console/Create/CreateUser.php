<?php

namespace Creativeorange\LaravelStubs\Console\Create;

use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an user';

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

        $model = config('laravel-stubs.create.user.model');
        \var_dump($model);

        if (!\class_exists($model)) {

            return $this->error('Model does not exist.');
        }

        $fields = config('laravel-stubs.create.user.fields');

        if (!\is_array($fields))
            $fields = [$fields];

        $saving = [];
        foreach ($fields as $key => $field) {

            if (!\is_array($field)) {

                $key = $field;
                $field = [
                    'name' => \ucfirst($field),
                    'type' => 'ask'
                ];
            }

            if (!isset($field['name'])) {
                $field['name'] = \ucfirst($key);
            }

            if (!isset($field['type'])) {
                $field['type'] = 'ask';
            }

            switch (\strtolower($field['type'])) {
                case 'secret':

                    $saving[$key] = \bcrypt($this->secret($field['name']));
                    break;
                default:
                    $saving[$key] = $this->ask($field['name']);
            }
        }

        if (!empty(config('laravel-stubs.create.user.unique')) &&
            $model::where(config('laravel-stubs.create.user.unique'),
                            $saving[config('laravel-stubs.create.user.unique')])->first()) {

            $this->error('This user already exists.');
        }
        else {

            $model::create($saving);

            $this->info('User created successfully');
        }
    }
}
