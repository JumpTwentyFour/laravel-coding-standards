# Laravel Coding Standards

At [Jump24](https://jump24.co.uk/) we pride ourselves on keeping our coding standards under tight control, this is why we built this package.

## Installation

To install this package, simply use composer:

```bash
composer require jumptwentyfour/laravel-coding-standards
```


## Setup

Once installed you will have access to our PHPStan configuration file, which you can easily add to your `phpstan.neon`:

```neon
includes:
    - ./vendor/jumptwentyfour/laravel-coding-standards/phpstan.neon
```

## Running

To run the code standard checks, simply run the following command:

```bash
./vendor/bin/ecs check
```
This will run the configured code standard checks for you, giving you feedback on where your code is and what improvements you need to implement

## Extending

These code standards are extendable, all you need to do is create your own `ecs.php` in the root directory of your project:

```php
<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/vendor/jumptwentyfour/laravel-coding-standards/ecs.php');

    $parameters = $containerConfigurator->parameters();
    
    $parameters->set(Option::PATHS, [
        __DIR__ . '/app',
        __DIR__ . '/tests',
    ]);
};
```
