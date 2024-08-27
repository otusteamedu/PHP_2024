<?php
declare(strict_types=1);


require_once __DIR__ . '/../vendor/autoload.php';

use FTursunboy\App\App;

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
