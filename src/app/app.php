<?php

declare(strict_types=1);

require_once('../vendor/autoload.php');

use ChatOtus\App\App;

/** @var $argv array params from cli */
try {
    $app = new App($argv[1]);
    $app->run();
} catch (Exception $e) {
    echo "Ошибка:" . $e->getMessage();
}