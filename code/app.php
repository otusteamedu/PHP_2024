<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Ekonyaeva\Otus\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage();
}