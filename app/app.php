<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw14\App;

try {
    $mode = $argv[1] ?? 'empty mode';
    (new App($mode))
        ->run();
} catch (Exception $e) {
    echo 'Error: ==========================================';
    echo PHP_EOL;
    echo $e->getMessage();
    echo PHP_EOL;
}
