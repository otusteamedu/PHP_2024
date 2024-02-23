<?php

declare(strict_types=1);

use Rmulyukov\Hw5\App;

require __DIR__ . "/../vendor/autoload.php";

try {
    (new App())->run();
} catch (Throwable $e) {
    var_dump($e->getMessage());
}
