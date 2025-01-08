<?php

require 'vendor/autoload.php';

use VladimirGrinko\Rabbit\View\View;

try {
    $app = new View();
    $app->run();
} catch (\Throwable $th) {
    echo $th->getMessage();
}