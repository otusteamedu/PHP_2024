<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Application;

try {
    (new Application())->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
