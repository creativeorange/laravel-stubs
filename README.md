# laravel-stubs

# Commands

#### Create
- create:user

  Creates a new user for the application. 
  The default model is '\App\User'.
  Default there will be an unique check on the 'email' field.
  The fields prompted for are 'name, email and passowrd'

#### Make
- make:interface

  Creates a new interface, by default this will be stored in 'App/Interfaces'.
  An interface will always automatically be prefixed with 'Interface' according to the PSR naming conventions.

- make:trait

  Creates a new trait, by default this will be stored in 'App/Traits'.
  An interface will always automatically be prefixed with 'Trait' according to the PSR naming conventions.

#### Publish
- publish:stubs

  Publishes all the stubs used for the package.

#### Run
- run:factory

  Prompts for a model and an amount, then runs the corresponding factory.
