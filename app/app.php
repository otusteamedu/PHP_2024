<?php

declare(strict_types=1);

include 'vendor/autoload.php';

use Dsmolyaninov\Hw5\Core\App;

try {
    if (php_sapi_name() === 'cli') {
        $app = new App();
        $app->run($argc, $argv);
    } else {
        throw new Exception('Скрипт предназначен для запуска из командной строки.');
    }
} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage() . PHP_EOL;
}
