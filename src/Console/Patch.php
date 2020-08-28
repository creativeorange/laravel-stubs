<?php

namespace Creativeorange\LaravelStubs\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class Patch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'patch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Patch laravel';

    protected $signature = 'patch';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->handleLanguagePatching();

        $this->info('Successfully patched Laravel :)');
    }

    private function handleLanguagePatching()
    {
        foreach (\config('laravel-stubs.patch.language_tags') as $tag => $replacement) {
            $tmpTag = $replacement;

            do {
                if (empty($tag)) {
                    $replacement = $this->ask('With which language tag do you want to replace `' . $tmpTag . '`?');
                }

                $languageTag = Lang::get($replacement);

                if ($languageTag === $replacement) {
                    $this->error('`' . $replacement . '` can not be found');
                }
            }
            while ($languageTag === $replacement);

            $tag = $tmpTag;

            $explodedLanguageTag = explode('.', $tag);

            foreach (File::directories(config('laravel-stubs.patch.language_folder')) as $languagePath) {
                $explodedLanguagePath = explode('/', $languagePath);
                $currentLanguage = end($explodedLanguagePath);

                $file = \array_shift($explodedLanguageTag);
                $currentLanguageFile = Lang::get($file, [], $currentLanguage);

                $toBeChanged = &$currentLanguageFile;
                foreach ($explodedLanguageTag as $level) {
                    $toBeChanged = &$toBeChanged[$level];
                }
                $toBeChanged = $languageTag;

                $fileContents = \file_get_contents($languagePath . '/' . $file . '.php');
                $fileContents = preg_replace('/(\'' . end($explodedLanguageTag) . '\' => )(.+)/', '$1\'' . $languageTag . '\',', $fileContents);

                \file_put_contents($languagePath . '/' . $file . '.php', $fileContents);
            }
        }
    }
}
