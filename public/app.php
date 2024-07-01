<?php

declare(strict_types=1);

use Rrazanov\Hw5\App;

include __DIR__ . '/../code/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo 'Код ' . $e->getCode() . ': ' . $e->getMessage() . "\n";
}
