<?php

use Ahar\hw15\Application;

require '../vendor/autoload.php';

try {
    $app = new Application();
    $app->run();
} catch (Exception $e) {
    echo 'Error ' . $e->getMessage();
}
