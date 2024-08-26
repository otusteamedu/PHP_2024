<?php

use Komarov\Hw5\App\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
