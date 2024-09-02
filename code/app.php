<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use TimurShakirov\SocketChat\App;

$app = new App();

try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
