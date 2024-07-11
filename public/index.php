<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Alogachev\Homework\App;

try {
    $app = new App();
    $app->run();
} catch (Throwable $exception) {
    echo $exception->getMessage() . '<br>';
}
