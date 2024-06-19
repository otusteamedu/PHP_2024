<?php

use App\src\App;

require '../vendor/autoload.php';
require 'Support/helpers.php';

try {
    $startDir = readline('Dir path: ');
    $app = new App($startDir, ['..', '.', '.github', '.git', '.idea']);
    echo $app->run();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
