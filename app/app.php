<?php

use App\src\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
