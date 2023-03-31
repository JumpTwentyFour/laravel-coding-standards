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

declare(strict_types=1);

use JumpTwentyFour\PhpCodingStandards\Support\ConfigHelper;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import(__DIR__ . '/vendor/jumptwentyfour/laravel-coding-standards/ecs.php');

    $ecsConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);
    
    $ecsConfig->skip(array_merge(ConfigHelper::make()->getParameter(Option::SKIP), [
        UnusedParameterSniff::class => [
            __DIR__ . '/app/Console/Kernel.php',
            __DIR__ . '/app/Exceptions/Handler.php',
        ],
        'Unused parameter $attributes.' => [
            __DIR__ . '/database/*.php',
        ],
        CamelCapsFunctionNameSniff::class => [
            '/tests/**',
        ],
    ]));
};
```
