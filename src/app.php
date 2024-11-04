<?php

use VSukhov\Hw14\App\App;
use VSukhov\Hw14\Exception\AppException;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $limit = 100;
    $offset = 0;
    $users = $app->run($limit, $offset);

    return $users;
} catch (AppException $e) {
    echo $e->getMessage();
}
