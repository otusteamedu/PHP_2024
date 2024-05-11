<?php

declare(strict_types=1);

include 'vendor/autoload.php';

use ABuynovskiy\Hw5\App;

try {
    if (php_sapi_name() === 'cli') {
        $app = new App();
        $app->run($argc, $argv);
    } else {
        throw new Exception('Работает только с командной строки.');
    }
} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage() . PHP_EOL;
}
