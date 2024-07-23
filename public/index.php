<?php

use App\Infrastructure\Main\App;
use App\Infrastructure\Main\Request;

require '../vendor/autoload.php';
require '../app/Infrastructure/Support/helpers.php';

try {
    echo App::getInstance()->run(new Request());
} catch (Exception $exception) {
    echo $exception->getMessage();
}