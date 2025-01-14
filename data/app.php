<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Apeskovatzkov\Hw5\Application\Application;
use Apeskovatzkov\Hw5\Container;

try {
    $app = new Application(
        (new Container())->get($argv[1])
    );
    $app->run();
} catch (Throwable $th) {
    echo $th->getMessage();
}