<?php

require 'App.php';

try {
    App::run();
} catch (Exception $exception) {
    http_response_code($exception->getCode());
    echo $exception->getMessage() . PHP_EOL;
    return;
}
