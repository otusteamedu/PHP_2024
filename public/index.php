<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use AShutov\Hw14\App;

$settings = require __DIR__ . '/../config/settings.php';
$env = parse_ini_file(__DIR__ . '/../.env');
$dump = __DIR__ . '/../data/books.json';

try {
    $app = new App($settings, $env, $dump);
    echo $app->run();
} catch (Throwable $e) {
    echo $e->getMessage();
}
