<?php

require '../vendor/autoload.php';

return [
    "psql" => [
        "host" => $_ENV["DB_HOST"],
        "name" => $_ENV["DB_NAME"],
        "user" => $_ENV["DB_USER"],
        "pass" => $_ENV["DB_PASS"],
        "port" => $_ENV["DB_PORT"]
    ],
    "redis" => [
        "host" => $_ENV["REDIS_HOST"],
        "port" => $_ENV["REDIS_PORT"],
        "auth" => $_ENV["REDIS_AUTH"]
    ]
];