<?php

declare(strict_types=1);

use function App\runApp;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = runApp();

echo $app;
