<?php

use Ahor\Hw5\App;

require('../vendor/autoload.php');


try {
    $app = new App(__DIR__ . '/../config/config.ini');
    $app->run($argv[1] ?? null);
} catch (Exception $e) {
    echo "ERROR" . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
}
