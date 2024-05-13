<?php

declare(strict_types=1);

use App\App;

require_once 'vendor/autoload.php';

try {
    $app = new App();

    $app->run();
} catch (Exception $e) {
    echo '[ERROR]: ' . $e->getMessage();
}