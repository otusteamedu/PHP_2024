<?php

require '../vendor/autoload.php';

use AKornienko\hw5\App;

try {
    $app = new App();
    $messages = $app->run();

    foreach ($messages as $message) {
        print_r(PHP_EOL . $message . PHP_EOL);
    }
} catch (Exception $e) {
    print_r($e->getMessage());
}
