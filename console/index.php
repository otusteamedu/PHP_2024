<?php

declare(strict_types=1);

use App\runners\ConsoleRunner;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new ConsoleRunner())->run();
} catch (Throwable $exception) {
    echo "Ошибка: " . $exception->getMessage() . "\n";
}
