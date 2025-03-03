<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use AnatolyShilyaev\App\App;

try {
    $app = new App();
    $message = $app->run();
    print_r(PHP_EOL . $message . PHP_EOL);
} catch (Exception $e) {
    print_r($e->getMessage());
}
