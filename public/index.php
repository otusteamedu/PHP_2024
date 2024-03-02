<?php

require_once '../vendor/autoload.php';

use AKornienko\Php2024\App;

try {
    $app = new App();
    $messages = $app->run();
    foreach ($messages as $message) {
        print_r($message . PHP_EOL);
    }
} catch (Exception $exception) {
    print_r($exception);
}
