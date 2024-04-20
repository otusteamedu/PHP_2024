<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Igor\ValidateBrackets\App;

try {
    $app = new App();
    echo $app->run();
} catch (Exception $e) {
    try {
        http_response_code(400);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    echo $e->getMessage();
}
