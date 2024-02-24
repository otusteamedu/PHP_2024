<?php

declare(strict_types=1);

use App\Base;
use App\SocketErrorException;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new Base();
    $app->run();
} catch (SocketErrorException $e) {
     echo $e->getErrorMessage() . PHP_EOL;
}
