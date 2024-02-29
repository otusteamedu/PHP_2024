<?php

use App\src\App;
use App\src\Enums\CommandEnum;

require '../vendor/autoload.php';

try {
    $app = new App();
    $fiber = $app->run();
    $message = $fiber->start();

    while (CommandEnum::tryFrom($message) !== CommandEnum::STOP) {
        $message = $fiber->resume();
        echo $message . PHP_EOL;
    }

} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

