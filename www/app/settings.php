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
            $env = getenv('ENV') ?? 'production';

            return new Settings([
                'env' => $env,

                'displayErrorDetails' => $env !== 'production', // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'driver' => 'pdo_pgsql',
                    'user' => getenv('POSTGRES_USER'),
                    'password' => getenv('POSTGRES_PASS'),
                    'dbname' => getenv('POSTGRES_DBNAME'),
                    'host' => getenv('POSTGRES_HOST'),
                    'port' =>  (int) getenv('POSTGRES_POST'),
                ],
                'rabbit' => [
                    'user' => getenv('RABBITMQ_USER'),
                    'pass' => getenv('RABBITMQ_PASS'),
                    'queue' => getenv('RABBITMQ_QUEUE'),
                    'host' => getenv('RABBITMQ_HOST'),
                    'port' => (int) getenv('RABBITMQ_PORT'),
                ],
                'generationStrategy' => getenv('GENERATION_STRATEGY'),
                'yandexArt' => [
                    'folder_id' => getenv('FOLDER_ID'),
                    'yandex_oauth_token' => getenv('YANDEX_OAUTH_TOKEN'),
                ]
            ]);
        }
    ]);
};
