<?php
require_once "vendor/autoload.php";

use GoroshnikovP\Hw6\App;
use GoroshnikovP\Hw6\Exceptions\PrepareException;
use GoroshnikovP\Hw6\Exceptions\RuntimeException;

try {
    $app = new App();
    $app->run();
}
catch(PrepareException $ex){
    echo "Проблема при старте: \n";
    print_r([

        'message' =>  $ex->getMessage(),
        'code' =>  $ex->getCode(),
        'file' =>  $ex->getFile(),
        'line' =>  $ex->getLine(),
    ]);
}
catch(RuntimeException $ex){
    echo "Проблема при выполнении: \n";
    print_r([

        'message' =>  $ex->getMessage(),
        'code' =>  $ex->getCode(),
        'file' =>  $ex->getFile(),
        'line' =>  $ex->getLine(),
    ]);
}
catch(Throwable $ex){
    echo "Пропустили экзепшен(((\n";
    print_r($ex);
}
