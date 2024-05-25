<?php

declare(strict_types=1);

use App\Infrastructure\Settings\{Settings, SettingsInterface};
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
                    'name' => 'media-monitoring',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'driver' => 'sqlite',
                    'database' => __DIR__ . '/../db/database.sqlite3',
                ],
                'path_to_reports_dir' => __DIR__ . '/../tmp'
            ]);
        }
    ]);
};
