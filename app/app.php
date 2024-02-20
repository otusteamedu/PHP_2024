<?php

declare(strict_types=1);

require_once(__DIR__ . '/vendor/autoload.php');

use Hukimato\SocketChat\App;

try {
    $app = new App($argv[1], $argv[2]);
    $app->run();
} catch (\Throwable $e) {
    print "Не удается инициализировать прилоежние." . PHP_EOL;
    print $e->getMessage() . PHP_EOL;
}

