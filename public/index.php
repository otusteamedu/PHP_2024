<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Alogachev\Homework\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
