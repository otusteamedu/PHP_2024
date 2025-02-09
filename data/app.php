<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Apeskovatzkov\Hw5\Application\Application;
use Apeskovatzkov\Hw5\ApplicationTypes;

try {
    $app = new Application(ApplicationTypes::tryFromOrFail($argv[1]));
    $app->run();
} catch (Throwable $th) {
    echo $th->getMessage();
}
