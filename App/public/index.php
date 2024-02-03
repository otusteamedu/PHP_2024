<?php
require '../../vendor/autoload.php';

Predis\Autoloader::register();

$connection = new App\Config\Connection('../../.env');
$connection->test();