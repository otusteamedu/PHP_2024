<?php

declare(strict_types=1);

use Dsergei\Hw12\App;

require "vendor/autoload.php";

try {
    echo (new App())->run();
} catch (Throwable $exception) {
    echo $exception->getFile() . PHP_EOL;
    echo $exception->getLine() . PHP_EOL;
    echo "Error: " . $exception->getMessage() . "\n";
}
