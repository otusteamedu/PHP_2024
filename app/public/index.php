<?php

declare(strict_types=1);

use Kagirova\Hw21\App;
use Kagirova\Hw21\Application\Response\Response;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    Response::json($exception->getMessage(), $exception->getCode());
}
