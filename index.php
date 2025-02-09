<?php

use KRudenko\Otus\Core\Kernel;

require __DIR__ . "/vendor/autoload.php";

$kernel = new Kernel();
$kernel->boot();
echo $kernel->handleCommand();
