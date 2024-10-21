<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/app/vendor/autoload.php';

use App\Controller\Console\FrontController;
use App\Controller\Exception\SocketException;

try {
    $app = new FrontController();

    foreach ($app->run($argv) as $message) {
        echo $message;
    }
} catch (SocketException $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
