<?php

declare(strict_types=1);

require_once('./vendor/autoload.php');

use Igorkachko\OtusSocketApp\App;

try {
    $app = new App();
    $app->run();
}
catch(Exception $e){
    fwrite(STDERR, $e->getMessage());
    fwrite(STDOUT, PHP_EOL);
}