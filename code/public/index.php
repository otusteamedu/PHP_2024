<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use TBublikova\Php2024\App;

try {
    $app = new App();
    $response = $app->run();

    echo $response . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
