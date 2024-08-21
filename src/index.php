<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Komarov\Hw4\App;

try {
    (new App())->run();
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo $e->getMessage();
}
