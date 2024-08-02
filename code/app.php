<?php

declare(strict_types=1);

use Viking311\Books\Application\Application;

require 'vendor/autoload.php';

try {
    $app = new Application();
    $app->run();
} catch (Exception $ex) {
    fwrite(STDOUT, 'Exception: ' . $ex->getMessage() . PHP_EOL) ;
}
