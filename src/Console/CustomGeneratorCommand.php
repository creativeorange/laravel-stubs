<?php

namespace Creativeorange\LaravelStubs\Console;

use Illuminate\Console\GeneratorCommand;

abstract class CustomGeneratorCommand extends GeneratorCommand
{

    protected function resolveStubPath($stub)
    {
        return (file_exists($customPath = $this->laravel->basePath(trim($stub, '/'))) && \file_exists($customPath))
            ? $customPath
            : __DIR__.$stub;
    }
}