<?php

require('vendor/autoload.php');

use Dmigrishin\FirstHomework\FirstHomework;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

FirstHomework::connect();




?>