<?php

declare(strict_types=1);

use SergeyShirykalov\HomeworkRabbit\App;

require __DIR__ . '/../vendor/autoload.php';

// Looing for .env at the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

echo App::run();
