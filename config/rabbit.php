<?php

return [
    'host' => getenv("RABBIT_HOST"),
    'port' => getenv("RABBIT_PORT"),
    'user' => getenv("RABBIT_USER"),
    'password' => getenv("RABBIT_PASSWORD"),
    'queue_name' => env('RABBIT_QUEUE_NAME', 'bank'),
];
