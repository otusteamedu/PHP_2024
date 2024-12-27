<?php

return [
    'database' => [
        'host' =>  getenv('DATABASE_HOST') ?  getenv('DATABASE_HOST'): 'DB',
        'user' => getenv('MYSQL_USER') ? getenv('MYSQL_USER') : 'user',
        'password' => getenv('MYSQL_PASSWORD') ? getenv('MYSQL_PASSWORD') : 'password',
        'db' => getenv('MYSQL_DATABASE') ? getenv('MYSQL_DATABASE') : 'database'
    ]
];
