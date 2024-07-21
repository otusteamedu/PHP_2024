<?php

declare(strict_types=1);

use console\components\FileTarget;
use yii\console\controllers\MigrateController;

return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'bootstrap' => [
        'log',
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationPath' => null,
            'migrationNamespaces' => [
                'common\migrations\db',
            ],
            'migrationTable' => '{{%system_db_migration}}',
        ],
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG || YII_ENV_TEST ? 3 : 0,
            'flushInterval' => 1,
            'targets' => [
                'console' => [
                    'class' => FileTarget::class,
                    'levels' => ['info', 'warning', 'error'],
                    'logVars' => [],
                    'exportInterval' => 1,
                ],
            ],
        ],
    ],
];
