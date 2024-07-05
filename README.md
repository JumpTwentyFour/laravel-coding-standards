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

These code standards are extendable, all you need to do is create your own `ecs.php` in the root directory of your project and copy the following and extend as required:

```php
<?php

declare(strict_types=1);

return ECSConfig::configure()
    ->withSets([getcwd() . '/vendor/jumptwentyfour/php-coding-standards/ecs.php'])
    ->withPaths(
        [
            __DIR__ . '/ecs.php',
            __DIR__ . '/src',
        ]
    );
```
