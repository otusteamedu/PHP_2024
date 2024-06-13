<?php

declare(strict_types=1);

use Kagirova\Hw21\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    if (isset($argv)) {
        $app->run($argv[1]);
    }
    else {
        $app->run('sender');
    }
} catch (Exception $exception) {
    echo $exception->getMessage();
}
