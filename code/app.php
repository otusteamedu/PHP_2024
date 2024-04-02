<?php
declare(strict_types=1);

use App\App;

require_once(__DIR__.'/vendor/autoload.php');

try {
    $app = new App($argv[1]);
    $app->run();
} catch(Exception $e) {
    throw new Exception($e->getMessage());
}

