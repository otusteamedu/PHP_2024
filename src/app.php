<?php

use VSukhov\Hw14\App\App;
use VSukhov\Hw14\Exception\AppException;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new App())->run();
} catch (AppException $e) {
    echo $e->getMessage();
}
