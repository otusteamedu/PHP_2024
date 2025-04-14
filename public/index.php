<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

//use Elastic\Elasticsearch\ClientBuilder;
//use Elastic\Elasticsearch\Response\Elasticsearch;
//use Http\Mock\Client;
//use Nyholm\Psr7\Response;
//
//$mock = new Client(); // This is the mock client
//
//$client = ClientBuilder::create()
//    ->setHttpClient($mock)
//    ->build();
//
//// This is a PSR-7 response
//$response = new Response(
//    200,
//    [Elasticsearch::HEADER_CHECK => Elasticsearch::PRODUCT_NAME],
//    'This is the body!'
//);
//$mock->addResponse($response);
//
//$result = $client->info(); // Just calling an Elasticsearch endpoint
//
//echo $result->asString(); // This is the body!


$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
