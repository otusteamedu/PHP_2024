<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use IGalimov\Hw5\App;

try {
    $app = new App();
    $messages = $app->run();

    foreach ($messages as $message) {
        echo $message;
    }
} catch (Exception $e) {
    echo "Error:\n - " . $e->getMessage() . "\n";
}
