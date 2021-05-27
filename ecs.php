<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/ecs.php',
        __DIR__ . '/src',
    ]);

    $containerConfigurator->import(getcwd() . '/vendor/jumptwentyfour/php-coding-standards/ecs.php');
};
