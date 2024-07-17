<?php

use Naimushina\Chat\App;

require_once __DIR__ . '/vendor/autoload.php';


$app = new App();

try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
