<?php

require_once 'App.php';

try {
    $app = new App();
    echo $app->run();
} catch (Exception $e) {
    http_response_code(500);
    echo "Internal Server Error: " . $e->getMessage();
}
