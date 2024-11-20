<?php

ini_set('display_errors', 1);
require_once 'vendor/autoload.php';

try {
    $app = new \IraYu\App();
    $app->run();
} catch (\Exception $e) {
    throw $e;
}
