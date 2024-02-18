<?php

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../';

// Composer
require($dirEnv . 'vendor/autoload.php');
require($dirEnv . 'autoload.php');

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable($dirEnv);
$dotenv->load();

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$stringService = new \services\BracketsService(
    new \helpers\Brackets()
);

$stringService->validate($request->get('string', ''));



/*$memcached = new \helpers\MemcachedService(
    getenv('MEMCACHED_HOST'),
    getenv('MEMCACHED_PORT')
);
echo 'Memcached version - ' . $memcached->ping() . "\r\n";*/
