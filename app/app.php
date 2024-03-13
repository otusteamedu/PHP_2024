<?php

declare(strict_types=1);

require('vendor/autoload.php');

use Dsergei\Hw6\App;

try {
    $app = new App();
    if($app->run()) {
        echo 'All emails is valid' . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error: {$e->getMessage()}" . PHP_EOL;
}
