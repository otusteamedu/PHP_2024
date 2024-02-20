<?php

declare(strict_types=1);

use function App\runApp;

require_once __DIR__ . '/../src/app.php';

$app = runApp();

echo $app;
