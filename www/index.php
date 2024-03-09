<?php

require __DIR__ . '/vendor/autoload.php';

use Otus\BracketValidator;
use Otus\RequestHandler;

$validator = new BracketValidator();
$requestHandler = new RequestHandler($validator);
$requestHandler->handleRequest();

echo 'PHP-FPM контейнер: ' . $_SERVER['HOSTNAME'] . '</br>';