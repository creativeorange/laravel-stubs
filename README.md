# laravel-stubs

Laravel stubs aims to add some "missing" functionality to the artisan commands that currently exist.

## Installation

First, pull in the package through Composer via the command line:
```
composer require creativeorange/gravatar ~1.0
```

or add the following to your composer.json file and run `composer update`.

```
"require": {
    "creativeorange/gravatar": "~1.0"
}
```

## Commands

#### Create
- ##### create:user

  Creates a new user for the application. 
  The default model is `\App\User`.
  Default there will be a unique check on the `email` field.
  The fields prompted for are: name, email and password.
  
#### Dispatch
- ##### dispatch:job

  Easy way to dispatch a job.
  ##### Arguments
    - Job - The class of the job. Include the namespace.
    - Arguments - An array of parameters to send along to the constructor of the job.

#### Make
- ##### make:facade

  Creates a new facade, by default this will be stored in `App/Facades.`
  A facade will automatically be suffixed with `Facade`.
  ##### Arguments
    - Name - The name of the facade.
    - Accessor - The class the facade references to.

- ##### make:interface

  Creates a new interface, by default this will be stored in `App/Interfaces`.
  An interface will always automatically be suffixed with `Interface` according to the PSR naming conventions.
  ##### Arguments
    - Name - The name of the interface.

- ##### make:scope

  Creates a new trait, by default this will be stored in `App/Scopes`.
  A scope will always automatically be suffixed with `Scope`.
  ##### Arguments
    - Name - The name of the scope.

- ##### make:trait

  Creates a new trait, by default this will be stored in `App/Traits`.
  A trait will always automatically be suffixed with `Trait` according to the PSR naming conventions.
  ##### Arguments
    - Name - The name of the trait.
  ##### Options
    - Boot | b - Makes a boot trait instead of an empty one.
    - Uuid | u - Makes a trait to fill a field with an uuid on creation.
    - Anonymous | a - Makes a trait to anonymous data on soft deletes.

- ##### make:view:composer

  Creates a new trait, by default this will be stored in `App/Http/View/Composers`.
  A view composer will always automatically be suffixed with `Composer`.
  ##### Arguments
  - Name - The name of the view composer.
  
#### Patch
- ##### patch
    
  Patch some basic things you might not like about laravel.
  Supports the patching of the following things:
  - Language tags
    - Replaces a language tag with another language tag for all languages.
  
#### Publish
- ##### publish:config

  Publishes the config used for the package. 
  This can also be done with:
  ```
    php artisan vendor:publish --provider="Creativeorange\LaravelStubs\LaravelStubsServiceProvider" --tag="config"
  ``` 
  ##### Options
  - Force | f - Forces the stubs to be overwritten.
  
- ##### publish:stubs

  Publishes all the stubs used for the package.
  ##### Options
  - Force | f - Forces the stubs to be overwritten.

#### Run
- ##### run:factory

  Prompts for a model and an amount, then runs the corresponding factory.
  ##### Arguments
  - Model - The model to run the factory for. If not provided will be asked on the go.
  - Amount - The amount to create with the factory. If not provide will be asked on the go.
