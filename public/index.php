<?php

use App\App;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new App();

unset($argv[0]);

$app->run(...$argv);