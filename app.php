<?php

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new SocketChat\App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
