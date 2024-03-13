<?php

declare(strict_types=1);

require_once "vendor/autoload.php";
use GoroshnikovP\Hw7\App;
use GoroshnikovP\Hw7\Exception\AppException;

try {
    $app = new App();
    $result = $app->run();
    echo "$result\n";
} catch (AppException $ex) {
    echo "Ошибка: {$ex->getMessage()} \n";
}
