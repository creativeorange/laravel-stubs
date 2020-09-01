<?php

namespace Creativeorange\LaravelStubs\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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

    protected $signature = 'patch
                                {sections?* : Only run specific sections of the patch}
                                {--f|force : Overwrite any existing files}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = $this->confirm('Are you sure you want to start patching Laravel? 
            Before doing so please check your config and read the documentation on patching.');

        if ($start) {
            if ($this->shouldRun('language')) {
                $this->handleLanguagePatching();
            }
            if ($this->shouldRun('config')) {
                $this->handleConfigPatching();
            }
            if ($this->shouldRun('cookie')) {
                $this->handleCookiePatching();
            }
            if ($this->shouldRun('htaccess')) {
                $this->handleHtaccessPatching();
            }

            $this->info('Successfully patched Laravel :)');
            $this->info('Please make sure to always validate the patches done.');
        }
    }

    private function shouldRun($name)
    {
        if (empty($this->argument('sections')) ||
            \in_array($name, $this->argument('sections'))) {
            return true;
        }

        return false;
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
                $explodedLanguagePath = $languagePath;
                if (in_array(\array_pop($explodedLanguagePath), \config('laravel-stubs.patch.language_exclude'))) {
                    continue;
                }

                $file = \array_shift($explodedLanguageTag);

                $fileContents = \file_get_contents($languagePath.'/'.$file.'.php');
                $fileContents = preg_replace('/(\''.end($explodedLanguageTag).'\' => )(.+)/', '$1\''.$languageTag.'\',',
                    $fileContents);

                \file_put_contents($languagePath.'/'.$file.'.php', $fileContents);
            }
        }

        $this->info('Language patching done.');
    }

    private function handleCookiePatching()
    {

        $facade = \file_get_contents(__DIR__.'/../stubs/cookies/cookie.stub');
        $facade = \str_replace('DummyNamespace', \ltrim(\config('laravel-stubs.make.facade.namespace'), '\\'), $facade);
        $path = \base_path().\str_replace('\\', '/', \config('laravel-stubs.make.facade.namespace')).'/Cookie.php';
        $this->creatDirectoryAndSaveFile($path, $facade, 'cookie facade');

        $jar = \file_get_contents(__DIR__.'/../stubs/cookies/cookiejar.stub');
        $jar = \str_replace('DummyNamespace', \ltrim(\config('laravel-stubs.patch.cookies.namespace'), '\\'), $jar);
        $path = \base_path().\str_replace('\\', '/', \config('laravel-stubs.patch.cookies.namespace')).'/CookieJar.php';
        $this->creatDirectoryAndSaveFile($path, $jar, 'cookie jar');

        $provider = \file_get_contents(__DIR__.'/../stubs/cookies/cookieserviceprovider.stub');
        $path = \base_path('app/Providers/CookieServiceProvider.php');
        $this->creatDirectoryAndSaveFile($path, $provider, 'cookie service provider');

        $sessionConfigPath = config('laravel-stubs.patch.config_folder').'/session.php';

        if (empty(config('session.cookie_prefix'))) {
            $fileContents = \file_get_contents($sessionConfigPath);
            $fileContents = preg_replace('/(];)/',
                "\n    'cookie_prefix' => ENV('SESSION_PREFIX_COOKIE', '__Secure-'),\n\n$1",
                $fileContents);
            \file_put_contents($sessionConfigPath, $fileContents);
        } else {
            $this->warn('Cookie_prefix setting already exists in session config');
        }

        $appConfigPath = \config('laravel-stubs.patch.config_folder').'/app.php';
        $fileContents = \file_get_contents($appConfigPath);
        $fileContents = \str_replace('Illuminate\Cookie\CookieServiceProvider::class',
            'App\Providers\CookieServiceProvider::class', $fileContents);
        $fileContents = \str_replace('Illuminate\Support\Facades\Cookie::class', 'App\Facades\Cookie::class',
            $fileContents);
        \file_put_contents($appConfigPath, $fileContents);

        $middlewarePath = \config('laravel-stubs.patch.middleware_folder').'/VerifyCsrfToken.php';
        $middlewareSerialized = \file_get_contents(__DIR__.'/../stubs/cookies/cookiemiddleware_serialized.stub');
        $middlewareAddCookieToResponse = \file_get_contents(__DIR__.'/../stubs/cookies/cookiemiddleware_addCookieToResponse.stub');
        $middlewareGetTokenFromRequest = \file_get_contents(__DIR__.'/../stubs/cookies/cookiemiddleware_getTokenFromRequest.stub');
        $use = \file_get_contents(__DIR__.'/../stubs/cookies/cookiemiddleware_use.stub');

        $fileContents = \file_get_contents($middlewarePath);
        if (!Str::contains($fileContents, $use)) {
            $fileContents = preg_replace('/(use .+;)([\s]+class)/', "$1\n".\preg_replace("/[ |\t]{2,}/", "", $use)."$2",
                $fileContents);
        }
        if (!Str::contains($fileContents, 'protected function getTokenFromRequest')) {
            $fileContents = preg_replace('/(class .*[\s\S]{[.|\s|\S]*)(})/', "$1\n".$middlewareGetTokenFromRequest."\n$2",
                $fileContents);
        }
        if (!Str::contains($fileContents, 'protected function addCookieToResponse')) {
            $fileContents = preg_replace('/(class .*[\s\S]{[.|\s|\S]*)(})/', "$1\n".$middlewareAddCookieToResponse."\n$2",
                $fileContents);
        }
        if (!Str::contains($fileContents, 'public static function serialized')) {
            $fileContents = preg_replace('/(class .*[\s\S]{[.|\s|\S]*)(})/', "$1\n".$middlewareSerialized."\n$2",
                $fileContents);
        }
        \file_put_contents($middlewarePath, $fileContents);

        $this->warn('Make sure to change the env values for local cookies or add a TLS certificate.');
        $this->info('Cookie patching done.');
    }

    private function handleConfigPatching()
    {
        foreach (\config('laravel-stubs.patch.config_options') as $option => $replacement) {
            $explodedConfigOption = explode('.', $option);

            $file = \array_shift($explodedConfigOption);
            $configPath = config('laravel-stubs.patch.config_folder').'/'.$file.'.php';

            $fileContents = \file_get_contents($configPath);
            $fileContents = preg_replace('/(\''.end($explodedConfigOption).'\' => )(.+)/', '$1'.$replacement.',',
                $fileContents);

            \file_put_contents($configPath, $fileContents);
        }

        $this->info('Config patching done.');
    }

    private function handleHtaccessPatching()
    {
        foreach (\config('laravel-stubs.patch.htaccess') as $groupName => $options) {
            $fileContents = \file_get_contents(config('laravel-stubs.patch.public_folder').'/.htaccess');

            $extraContents = "";
            $tabChar = "";
            $needsCloser = false;
            if ($options['needsModule']) {
                $tabChar = "    ";
                if (!Str::contains($fileContents, '<IfModule ' . $groupName . '>')) {
                    $needsCloser = true;
                    $groupName = "<IfModule " . $groupName . ">\n";
                    $extraContents .= $groupName;
                }
            }

            $prevFirstChar = null;
            foreach ($options['values'] as $value) {
                $value = \preg_replace("/[ |\t]{2,}/", \str_repeat($tabChar, 2), $value);

                if (!Str::contains($fileContents, $value)) {
                    if (!\is_null($prevFirstChar) && $prevFirstChar !== $value[0]) {
                        $extraContents .= "\n";
                    }

                    $extraContents .= $tabChar.$value."\n";
                    $prevFirstChar = $value[0];
                }
            }

            if ($needsCloser) {
                $extraContents .= "</IfModule>\n";
            }

            if (!empty($extraContents)) {
                if ($options['needsModule'] && !$needsCloser) {
                    $fileContents = \preg_replace('/('.$groupName.')([\s\S]+)(<\/IfModule>)/',
                        "$1$2\n".$extraContents."$3", $fileContents);
                } else {
                    $fileContents .= "\n".$extraContents;
                }
            }

            \file_put_contents(config('laravel-stubs.patch.public_folder').'/.htaccess', $fileContents);
        }

        $this->info('Htaccess patching done.');
    }

    private function creatDirectoryAndSaveFile($path, $content, $name)
    {
        $fileSystem = new Filesystem();
        if (!$fileSystem->isDirectory(dirname($path))) {
            $fileSystem->makeDirectory(dirname($path), 0777, true, true);
        }

        if (!\file_exists($path) || $this->option('force')) {
            \file_put_contents($path, $content);
        } else {
            $this->warn("The ".$name." already exists.");
        }
    }

    protected function getArguments()
    {
        return [
            ['sections', InputArgument::IS_ARRAY, 'Only run specific sections of the patch'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Overwrite any existing files'],
        ];
    }
}
