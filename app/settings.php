<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'driver' => 'sqlite',
                    'database' => __DIR__ . '/../db/database.sqlite3',
                ],
            ]);
        }
    ]);
};
