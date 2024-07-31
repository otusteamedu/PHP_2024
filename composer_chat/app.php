<?php

foreach (glob("src/*.php") as $filename) {
    include_once $filename;
};

use Chat\app\App;

try {
    $app = new App();
    $app->run($argv[1] ?? null);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
