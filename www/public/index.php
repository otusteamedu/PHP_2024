<?php

require __DIR__ . './../vendor/autoload.php';

use Otus\Application;

$application = new Application();
$application->run();

echo 'PHP-FPM контейнер: ' . $_SERVER['HOSTNAME'] . '</br>';
