<?php

require __DIR__ . '/vendor/autoload.php';

try {
    (new \App\ConsoleApp($argv))->run();
} catch (Throwable $e) {
    echo "Ошибка: {$e->getMessage()}\n";
    return 1;
}
