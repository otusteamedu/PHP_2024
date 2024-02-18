<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Dotenv\Dotenv;
use dtos\ResponseDto;
use services\BracketsService;
use helpers\Brackets;

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../';

// Composer
require($dirEnv . 'vendor/autoload.php');
require($dirEnv . 'autoload.php');

$dotenv = Dotenv::createUnsafeImmutable($dirEnv);
$dotenv->load();

$request = Request::createFromGlobals();
$stringService = new BracketsService(
    new Brackets()
);
/** @var ResponseDto $responseDto */
$responseDto = $stringService->validate($request->get('string', ''));

$response = new Response(
    $responseDto->getMessage(),
    $responseDto->getStatus(),
    ['content-type' => 'text/html']
);

return $response->send();



/*$memcached = new \helpers\MemcachedService(
    getenv('MEMCACHED_HOST'),
    getenv('MEMCACHED_PORT')
);
echo 'Memcached version - ' . $memcached->ping() . "\r\n";*/
