<?php

require_once __DIR__ . '/vendor/autoload.php';

use AgapitovAlexandr\OtusHomework\App;

try {
    (new App())->run();
} catch (Exception $exception) {
    var_dump($exception->getMessage());
}