<?php

declare(strict_types=1);

use App\runners\AppRunner;

require __DIR__ . '/../vendor/autoload.php';

try {
    $response = (new AppRunner())->run();
    http_response_code($response->getStatusCode());
    echo $response->toJson();
} catch (Throwable $exception) {
    echo "Ошибка: " . $exception->getMessage() . "\n";
}
