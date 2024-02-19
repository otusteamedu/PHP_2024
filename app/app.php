<?php

declare(strict_types=1);

use Dw\OtusSocketChat\Application\App;

require_once('../vendor/autoload.php');

try {
    $app = new App();
    $app->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
