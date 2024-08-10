<?php

use App\App;

const __ROOT__ = __DIR__ . '/../';

require_once __ROOT__ . '/vendor/autoload.php';

$app = new App();
$app->run();
