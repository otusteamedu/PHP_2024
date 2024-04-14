<?php

require_once '../vendor/autoload.php';

use AKornienko\Php2024\App;

try {
    $app = new App();
    $message = $app->run();
    print_r(PHP_EOL . $message . PHP_EOL);
} catch (Exception $e) {
    print_r($e->getMessage());
}
