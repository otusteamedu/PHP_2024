<?php

declare(strict_types=1);

use App\App\App;

require __DIR__ . '/../vendor/autoload.php';

$app = new App();

echo $app->run()->getContent();
