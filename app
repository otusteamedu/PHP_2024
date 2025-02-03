#!/usr/bin/env php

<?php

require __DIR__.'/vendor/autoload.php';

use KRudenko\Otus\Core\Kernel;

$kernel = new Kernel();
$kernel->handleCommand($argv);
