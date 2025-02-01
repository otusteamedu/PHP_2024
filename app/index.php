<?php

use Core\App;

require_once 'auto.php';

try {

    (new App())->run();

} catch (Exception $exception) {
    var_dump($exception->getMessage());
}