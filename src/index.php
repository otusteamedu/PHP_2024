<?php

require_once __DIR__ . '/autoloader.php';

use Core\App;


$app = new App();
echo $app->run();
