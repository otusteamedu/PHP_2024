<?php

use AlexAgapitov\OtusComposerProject\App;

require __DIR__.'/vendor/autoload.php';

try {

    (new App())->run();

} catch (Exception $exception) {
    var_dump($exception->getMessage());
}