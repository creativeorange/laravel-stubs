# laravel-stubs

## Commands

#### Create
- create:user

  Creates a new user for the application. 
  The default model is '\App\User'.
  Default there will be an unique check on the 'email' field.
  The fields prompted for are 'name, email and passowrd'

#### Make
- make:interface

  Creates a new interface, by default this will be stored in 'App/Interfaces'.
  An interface will always automatically be suffixed with 'Interface' according to the PSR naming conventions.

- make:trait

  Creates a new trait, by default this will be stored in 'App/Traits'.
  A trait will always automatically be suffixed with 'Trait' according to the PSR naming conventions.

- make:view:composer

  Creates a new trait, by default this will be stored in 'App/Http/View/Composers'.
  A view composer will always automatically be suffixed with 'Composer'.

- make:scope

  Creates a new trait, by default this will be stored in 'App/Scopes'.
  A scope will always automatically be suffixed with 'Scope'.

#### Publish
- publish:stubs

  Publishes all the stubs used for the package.

#### Run
- run:factory

  Prompts for a model and an amount, then runs the corresponding factory.
