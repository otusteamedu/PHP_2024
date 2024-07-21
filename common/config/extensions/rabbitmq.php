<?php

declare(strict_types=1);

use app\routing\consumers\ExecuteTasks;
use app\routing\consumers\SendApplication;
use app\routing\consumers\UpdateStatus;
use app\routing\entity\Queues;
use mikemadisonweb\rabbitmq\Configuration;
use yii\db\Exception;

return [
    'class' => Configuration::class,
    'connections' => [
        [
            'host' => env('RABBITMQ_HOST'),
            'port' => env('RABBITMQ_PORT'),
            'user' => env('RABBITMQ_USER'),
            'password' => env('RABBITMQ_PASSWORD'),
            'connection_timeout' => 20,
            'read_write_timeout' => 20,
        ],
    ],
    'queues' => [
        [
            'name' => Queues::ExecuteTasks->queuesName(),
            'durable' => true,
            'auto_delete' => false,
        ],
    ],
    'producers' => [
        [
            'name' => 'main_producers',
            'safe' => false,
        ],
    ],
    'consumers' => [
        [
            'name' => Queues::ExecuteTasks->consumersName(),
            'callbacks' => [
                Queues::ExecuteTasks->queuesName() => ExecuteTasks::class,
            ],
            'qos' => [
                'prefetch_size' => 0,
                'prefetch_count' => 10,
                'global' => false,
            ],
        ],
    ],
    'on before_consume' => static function ($event): void {
        if (Yii::$app->has('db') && Yii::$app->db->isActive) {
            try {
                Yii::$app->db->createCommand('SELECT 1')->query();
            } catch (Exception $exception) {
                Yii::$app->db->close();
            }
        }
    },
];
