<?php

require_once (__DIR__ . '/../vendor/autoload.php');

try {
    \Hukimato\Code\App::run();
} catch (\Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
    return;
}
