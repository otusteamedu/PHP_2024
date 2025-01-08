<?php

require 'vendor/autoload.php';

use VladimirGrinko\Rabbit\Client\Worker;

try {
    $worker = new Worker();
    $worker->run();
} catch (\Throwable $th) {
    echo $th->getMessage();
}
