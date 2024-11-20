<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use IGalimov\Hw41\Controllers\BracketsCheckController;

$app = new BracketsCheckController();

echo $app->initApp();
