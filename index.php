<?php

declare(strict_types=1);

require('./vendor/autoload.php');

use IgorKachko\CheckEmail\App;

$app = new App();
try {
    $app->run();
} catch (Exception $e) {
    fwrite(STDOUT, $e->getMessage());
    fwrite(STDOUT, PHP_EOL);
}