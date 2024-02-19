<?php

require_once('../vendor/autoload.php');

use AleksandrOrlov\Php2024\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
