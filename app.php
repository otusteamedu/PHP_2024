<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use Otus\SocketChat\App;
use Otus\SocketChat\SocketConfig;

$config = new SocketConfig();

try {
    $app = new App($config);
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
