<?php

declare(strict_types=1);

use Rrazanov\Hw4\App;

include __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    throw new \Exception($e->getMessage(), $e->getCode());
}
