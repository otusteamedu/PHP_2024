<?php
error_reporting(E_ALL);

ini_set('display_errors', true);

use Core\App;

require_once 'autoload.php';

try {
    (new App())->run();
} catch (Exception $exception) {
    var_dump($exception->getMessage());
}