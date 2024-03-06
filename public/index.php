<?php

declare(strict_types=1);

use App\App\App;

require __DIR__ . '/../vendor/autoload.php';

$response = (new App())->run();

echo $response->getContent();
