<?php
declare(strict_types=1);

namespace App;

require_once('vendor/autoload.php');

define('ROOT',dirname(__FILE__));

try {

    $app = new App();
    $app->run();

} catch (\Exception $e) {
    echo $e->getMessage(). PHP_EOL;
}