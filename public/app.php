<?php

use Alogachev\Homework\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
