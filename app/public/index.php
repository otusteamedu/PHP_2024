<?php

declare(strict_types=1);

use Rmulyukov\Hw\App;

require_once __DIR__ . "/../vendor/autoload.php";

try {
    (new App())->run();
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}