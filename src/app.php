<?php

require_once __DIR__ . '/../vendor/autoload.php';

use VSukhov\Hw12\App\App;

try {
    (new App())->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
