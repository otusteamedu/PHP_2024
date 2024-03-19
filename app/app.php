<?php

declare(strict_types=1);

if (!is_dir(__DIR__ . "/vendor")) {
    shell_exec("composer install --no-dev  -o -d " . __DIR__);
}

require './vendor/autoload.php';

use Lrazumov\Hw5\App;
use Lrazumov\Hw5\Config;

try {
    $config_path = __DIR__ . '/config.ini';
    $config = new Config($config_path);
    $config->load();
    $mode = $argv[1] ?? 'empty mode';
    (new App($mode, $config))
        ->run();
} catch (Exception $e) {
    print $e->getMessage();
    print PHP_EOL;
}
