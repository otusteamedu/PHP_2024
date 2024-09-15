<?php

declare(strict_types=1);

use Viking311\Chat\Application\ApplicationFactory;

require 'vendor/autoload.php';

try {
    $app = ApplicationFactory::getApplication();
    $app->run();
} catch (Exception $ex) {
    fwrite(STDOUT, 'Exception: ' . $ex->getMessage() . PHP_EOL) ;
}
