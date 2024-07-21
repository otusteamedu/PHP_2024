<?php

declare(strict_types=1);

use api\config\bootstrap\SetUp;
use api\modules\v1\Module;
use yii\web\JsonParser;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [SetUp::class],
    'modules' => [
        'v1' => [
            'class' => Module::class,
        ],
    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
            'enableCookieValidation' => false,
            'enableCsrfCookie' => false,
            'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '<module>/<controller>/<action>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>/index',
            ],
        ],
        'response' => [
            'format' => Response::FORMAT_JSON,
            'formatters' => [
                Response::FORMAT_JSON => [
                    'class' => JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG, // используем "pretty" в режиме отладки
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
    ],
];
