<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Igor\ValidateBrackets\App;

try {
    $app = new App();
    echo $app->run();
} catch (Exception $e) {
    http_response_code(400);
    echo $e->getMessage();
}
