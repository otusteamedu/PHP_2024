<?php

use Sfadeev\ChatApp\App;

require dirname(__DIR__) . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run($argv[1]);
} catch (Exception $e) {
    throw new RuntimeException("Unexpected error", 0, $e);
}
