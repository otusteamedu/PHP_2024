<?php
declare(strict_types=1);

use App\ServerRun;

require_once(__DIR__.'/vendor/autoload.php');

try {
    $app = new ServerRun($argv[1]);
    $app->run();
} catch(Exception $e) {
    throw new Exception($e->getMessage());
}

