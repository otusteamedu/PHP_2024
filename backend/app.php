<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use TBublikova\Php2024\ChatApp;

try {
    (new ChatApp())->run();
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
