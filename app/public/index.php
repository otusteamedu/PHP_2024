<?php

declare(strict_types=1);

use Kagirova\Hw31\App;
use Kagirova\Hw31\Domain\Response;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    if (isset($argv)) {
        $app->run($argv[1]);
    } else {
        $app->run('sender');
    }
} catch (Exception $exception) {
    Response::json($exception->getMessage(), $exception->getCode());
}
