<?php

use App\src\App;

require '../vendor/autoload.php';
require 'src/Support/helpers.php';

try {
    $startDir = readline('Dir path: ');
    $app = new App($startDir, ['..', '.', '.github', '.git', '.idea']);
    echo $app->run();
} catch (Throwable $e) {
    echo json_encode($e->getTrace());
    echo $e->getMessage() . PHP_EOL;
}
