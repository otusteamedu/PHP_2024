<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Otus\Chat\App;

try {
    (new App())->run();
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
