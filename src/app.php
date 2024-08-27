<?php

use VSukhov\Validator\App\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    (new App())->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
