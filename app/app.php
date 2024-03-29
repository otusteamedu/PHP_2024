<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw14\App;

try {
    $shortopts = getenv("SHORT_OPTIONS");
    $longopts = explode(',', getenv("LONG_OPTIONS"));
    $options = getopt($shortopts, $longopts);
    (new App($options))
        ->run();
} catch (Exception $e) {
    echo 'Error: ==========================================';
    echo PHP_EOL;
    echo $e->getMessage();
    echo PHP_EOL;
}
