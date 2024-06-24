<?php

use App\Core\App;

require_once(__DIR__ . '/../vendor/autoload.php');

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    fwrite(STDOUT, $e->getMessage());
}
