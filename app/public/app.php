<?php

require_once('../vendor/autoload.php');

use AleksandrOrlov\Php2024\App;

try {
    $app = new App();
    $data = $app->run();
    foreach ($data as $message) {
        echo $message;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
