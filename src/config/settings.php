<?php

declare(strict_types=1);

require_once __DIR__ . '/constants.php';

use AlexanderGladkov\CleanArchitecture\Infrastructure\Config\ApplicationConfig;

return function (ApplicationConfig $config): array {
    return [
        'general' => [
            'host' => 'http://application.local:8000',
        ],
        'slim' => [
            // Returns a detailed HTML page with error details and
            // a stack trace. Should be disabled in production.
            'displayErrorDetails' => true,

            // Whether to display errors on the internal PHP log or not.
            'logErrors' => true,

            // If true, display full errors with message and stack trace on the PHP log.
            // If false, display only "Slim Application Error" on the PHP log.
            // Doesn't do anything when 'logErrors' is false.
            'logErrorDetails' => true,
        ],

        'logger' => [
            'log_path' =>  RUNTIME_DIR . '/logs/app.log',
        ],

        'doctrine' => [
            // Enables or disables Doctrine metadata caching
            // for either performance or convenience during development.
            'development_mode' => true,

            // Path where Doctrine will cache the processed metadata
            // when 'dev_mode' is false.
            'cache_directory' => RUNTIME_DIR . '/doctrine',

            // List of paths where Doctrine will search for metadata.
            // Metadata can be either YML/XML files or PHP classes annotated
            // with comments or PHP8 attributes.
            'metadata_directories' => [APP_ROOT_DIR . '/CleanArchitecture/Domain/Entity'],

            // The parameters Doctrine needs to connect to your database.
            // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
            // needs a 'path' parameter and doesn't use most of the ones shown in this example).
            // Refer to the Doctrine documentation to see the full list
            // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
            'connection' => [
                'host' => $config->getDbHost(),
                'port' => $config->getDbPort(),
                'dbname' => $config->getDbName(),
                'user' => $config->getDbUser(),
                'password' => $config->getDbPassword(),
                'charset' => 'utf-8',
                'driver' => 'pdo_pgsql',
            ],
        ],

        'twig' => [
            'templates_directory' => APP_ROOT_DIR . '/template',
            'cache_directory' => RUNTIME_DIR . '/twig',
            'auto_reload' => true,
        ],
    ];
};
