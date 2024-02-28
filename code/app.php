<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use IGalimov\Hw5\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo "Error:\n - " . $e->getMessage() . "\n";
}
