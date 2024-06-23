<?php

declare(strict_types=1);


use Ahor\Hw19\AppConsole;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new AppConsole())->run($argv[1]);
} catch (Throwable $exception) {
    echo "Ошибка: " . $exception->getMessage() . "\n";
}
