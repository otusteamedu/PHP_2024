<?php

use src\Classes\Flow\App;

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    include $class . '.php';
});

$app = new App($_POST);
