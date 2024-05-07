<?php

declare(strict_types=1);

use JuliaZhigareva\OtusComposerPackage\App;

require '../vendor/autoload.php';

try {
    $app = new App();
    $app->run($argv[1] ?? null);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
