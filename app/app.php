<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw5\App;

try {
    (new App())
        ->run();
}
catch(Exception $e){
    print $e->getMessage();
}
