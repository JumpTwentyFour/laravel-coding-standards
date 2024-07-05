<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withSets([getcwd() . '/vendor/jumptwentyfour/php-coding-standards/ecs.php'])
    ->withPaths(
        [
            __DIR__ . '/ecs.php',
            __DIR__ . '/src',
        ]
    );
