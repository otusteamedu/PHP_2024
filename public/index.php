<?php

use App\Core\App;

require_once(__DIR__ . '/../vendor/autoload.php');

try {
    $app = new App();

    foreach ($app->run() as $output) {
        echo $output;
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
