<?php

declare(strict_types=1);

use JuliaZhigareva\ElasticProject\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    echo $app->run();
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
