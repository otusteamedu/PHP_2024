<?php

declare(strict_types=1);

use yii\debug\panels\RequestPanel;
use yii\gii\Module;

$config = [
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => true,
            'appendTimestamp' => YII_ENV_DEV,
        ],
    ],
];
if (YII_DEBUG_PANEL) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
        'panels' => [
            'request' => ['class' => RequestPanel::class, 'displayVars' => ['_GET', '_POST', '_COOKIE', '_FILES', '_SESSION']],
        ],
    ];
}

if (YII_DEBUG_PANEL) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '*'],
    ];
}

return $config;
