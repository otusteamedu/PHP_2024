<?php

declare(strict_types=1);

require_once "vendor/autoload.php";

use GoroshnikovP\Hw5\App;
use GoroshnikovP\Hw5\Exceptions\AppException;

$viewParams = [];
try {
    $app = new App();
    echo $app->run();
} catch (AppException $ex) {
    echo $ex->getMessage();
}
