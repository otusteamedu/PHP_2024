<?php

require '../vendor/autoload.php';

use Alogachev\Homework\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
}
