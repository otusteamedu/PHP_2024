<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/const.php';

use Udavikhin\OtusHw5\App;

try {
    $app = new App();
    $app->run();
} catch(Exception $e){
    echo $e->getMessage();
}