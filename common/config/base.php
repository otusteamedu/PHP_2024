<?php

declare(strict_types=1);

use common\config\bootstrap\DependencyInjection;
use common\config\bootstrap\SetUp;
use yii\caching\ApcCache;
use yii\caching\DummyCache;
use yii\caching\FileCache;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\log\DbTarget;
use yii\web\Session;

$config = [
    'name' => 'OTUS',
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'extensions' => ArrayHelper::merge(
        require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
        [
            'mikemadisonweb/yii2-rabbitmq' => [
                'bootstrap' => DependencyInjection::class,
            ],
        ]
    ),
    'sourceLanguage' => 'ru-RU',
    'language' => 'ru-RU',
    'bootstrap' => [
        'log',
        SetUp::class,
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}',
        ],

        'db' => [
            'class' => Connection::class,
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => 'utf8mb4',
            'enableSchemaCache' => YII_ENV_PROD,
            'emulatePrepare' => true,
        ],

        'rabbitmq' => require(__DIR__ . '/extensions/rabbitmq.php'),

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'flushInterval' => 1,
            'targets' => [
                'db' => [
                    'class' => DbTarget::class,
                    'exportInterval' => 1,
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\web\Session::init'],
                    'prefix' => static function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : (Yii::$app->controller->id . '/' . Yii::$app->controller->action->id);
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                    'logTable' => '{{%system_log}}',
                ],

            ],
        ],

        'session' => [
            'class' => Session::class,
            'cookieParams' => ['domain' => getenv('SESSION_COOKIE_DOMAIN')],
        ],
    ],
    'params' => [
        'domain' => env('DOMAIN'),
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
    ],
];

if (YII_ENV_PROD) {
    $config['components']['cache'] = [
        'class' => ApcCache::class,
        'keyPrefix' => env('CACHE_KEY_PREFIX', 'prod'),
        'useApcu' => true,
    ];
    $config['components']['fileCache'] = [
        'class' => FileCache::class,
        'cachePath' => '@api/runtime/cache',
        'fileMode' => 0o777,
    ];
    $config['components']['reqCache'] = [
        'class' => FileCache::class,
        'cachePath' => '@backend/runtime/req_cache',
        'fileMode' => 0o777,
    ];
}

if (YII_ENV_DEV || YII_ENV_TEST) {
    $config['components']['cache'] = [
        'class' => FileCache::class,
        'cachePath' => '@api/runtime/cache_main',
        'fileMode' => 0o777,
    ];
    $config['components']['fileCache'] = [
        'class' => DummyCache::class,
    ];

    $config['components']['reqCache'] = [
        'class' => FileCache::class,
        'cachePath' => '@api/runtime/req_cache',
        'fileMode' => 0o777,
    ];
}

return $config;
