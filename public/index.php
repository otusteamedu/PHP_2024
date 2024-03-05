<?php

declare(strict_types=1);

use App\App\App;

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json; charset=UTF-8');

$response = (new App())->run();

http_response_code($response->getCode());
echo $response->getContent();
