<?php

use App\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';
$app = new App();
echo $app->run();

