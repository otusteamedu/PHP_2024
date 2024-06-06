<?php

declare(strict_types=1);

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Pozys\BankStatement\Application;
use Pozys\BankStatement\Infrastructure\Http\ServerRequestCreatorFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$serverRequestCreator = new ServerRequestCreatorFactory();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$app = new Application();
$response = $app->handle($request);

(new SapiEmitter())->emit($response);
