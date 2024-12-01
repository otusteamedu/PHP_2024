<?php


return [
    'rabbitmq' => [
        'host' => 'localhost', // Адрес RabbitMQ сервера
        'port' => 5672,        // Порт RabbitMQ
        'user' => 'guest',     // Пользователь
        'password' => 'guest', // Пароль
        'queue' => 'task_queue', // Очередь
    ]
];
