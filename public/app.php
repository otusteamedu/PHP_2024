<?php

declare(strict_types=1);

use Afilipov\Hw12\App;

require "../vendor/autoload.php";

try {
    echo (new App())->run();
} catch (Throwable $exception) {
    echo "Ошибка: " . $exception->getMessage() . "\n";
}
