<?php


use VSukhov\Hw14\App\App;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new App())->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
