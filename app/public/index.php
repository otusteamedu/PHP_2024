<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

use AnatolyShilyaev\App\App;

(new App())->run();
