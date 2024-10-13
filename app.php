<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new VladimirGrinko\Redis\App\App();
    $app->run();
} catch (\Throwable $th) {
    echo $th->getMessage();
}
