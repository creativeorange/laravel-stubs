<?php

namespace Creativeorange\LaravelStubs\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

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
        $this->handleHtaccessPatching();

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
                $file = \array_shift($explodedLanguageTag);

                $fileContents = \file_get_contents($languagePath . '/' . $file . '.php');
                $fileContents = preg_replace('/(\'' . end($explodedLanguageTag) . '\' => )(.+)/', '$1\'' . $languageTag . '\',', $fileContents);

                \file_put_contents($languagePath . '/' . $file . '.php', $fileContents);
            }
        }
    }

    private function handleHtaccessPatching()
    {
        foreach (\config('laravel-stubs.patch.htaccess') as $groupName => $options) {
            $fileContents = \file_get_contents(\base_path('public/.htaccess'));

            $extraContents = "";
            $tabChar = "";
            $needsCloser = false;
            if ($options['needsModule']) {
                $tabChar = "\t";
                if (!Str::contains($fileContents, '<IfModule ' . $groupName . '>')) {
                    $needsCloser = true;
                    $groupName = "<IfModule " . $groupName . ">\n";
                    $extraContents .= $groupName;
                }
            }

            $prevFirstChar = null;
            foreach ($options['values'] as $value) {
                if (!Str::contains($fileContents, $value)) {
                    if (!\is_null($prevFirstChar) && $prevFirstChar !== $value[0]) {
                        $extraContents .= "\n";
                    }

                    $extraContents .= $tabChar . $value . "\n";
                    $prevFirstChar = $value[0];
                }
            }

            if ($needsCloser) {
                $extraContents .= "</IfModule>\n";
            }

            if (!empty($extraContents)) {
                if ($options['needsModule'] && !$needsCloser) {
                    $fileContents = \preg_replace('/(' . $groupName . ')([\s\S]+)(<\/IfModule>)/', "$1$2\n" . $extraContents . "$3", $fileContents);
                }
                else {
                    $fileContents .= "\n" . $extraContents;
                }
            }

            \file_put_contents(\base_path('public/.htaccess'), $fileContents);
        }
    }
}
