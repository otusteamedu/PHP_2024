<?php

declare(strict_types=1);

use SlavaMakhov\OtusQueueApp\App;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo 'Ошибка ' . $e->getCode() . ': ' . $e->getMessage() . PHP_EOL;
}
