# laravel-coding-standards
Jump Twenty Four Laravel Coding Standards

## Setup

Add the following to your `composer.json` file.
```
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/JumpTwentyFour/laravel-coding-standards"
        }
    ],
```

Then run the following commands:-

`composer require jumptwentyfour/laravel-coding-standards --dev`

You will also need to add the following to your local phpstan.neon file includes:

`- ./vendor/jumptwentyfour/laravel-coding-standards/phpstan.neon`

## Running PHP Easy Coding Standard
`vendor/bin/ecs check`

## Extending the Base ecs.php file
Create a new `ecs.php` file like the following example:-
```
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