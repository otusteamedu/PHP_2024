<?php

require __DIR__ . '/vendor/autoload.php';

use Otus\SocketChat\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
