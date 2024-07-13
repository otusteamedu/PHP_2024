<?php

use src\App\Main;

require_once 'vendor/autoload.php';

try {
    $app = new Main();
    $app->run($argv[1] ?? null);
} catch (Exception $e) {
    echo 'Error : ' . $e->getMessage();
}
