<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Otus\DbPattern\App;

try {
    (new App())->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
