<?php

use Naimushina\EventManager\App;

require_once __DIR__ . '/vendor/autoload.php';


$app = new App();

try {
    foreach ($app->run() as $message) {
        echo $message;
    };
} catch (Exception $e) {
    echo $e->getMessage();
}
