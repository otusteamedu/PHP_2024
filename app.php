<?php

require __DIR__ . '/vendor/autoload.php';

try {
    $iterator = (new \App\ConsoleApp($argv))->run();
    $iterator->rewind();
    while ($iterator->valid()) {
        echo $iterator->current();
        $iterator->next();
    }
} catch (Throwable $e) {
    echo "Ошибка: {$e->getMessage()}\n";
    return 1;
}
