<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use TBublikova\Php2024\App;

try {
    (new App())->run();
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}