<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ali\Socket\App;


$app = new App();

try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}