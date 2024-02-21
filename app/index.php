<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Lrazumov\Hw4\App;

echo (new App())
    ->run();

print phpinfo();