<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/app/vendor/autoload.php';

use App\App;
use App\Exception\SocketException;

try {
    $app = new App();

    foreach ($app->run($argv) as $message) {
        echo $message;
    }
} catch (SocketException $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
