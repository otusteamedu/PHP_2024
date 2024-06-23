<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Otus\Hw8\App;

try {
    $app = new App();
    $app->run();
    echo $app->getMessage();
} catch (\Exception $e) {
    echo "ERROR: {$e->getMessage()}" . PHP_EOL;
}
