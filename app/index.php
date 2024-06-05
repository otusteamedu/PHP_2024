<?php

require __DIR__ . '/vendor/autoload.php';


$checker = new App\CheckEnvironment();
$checker->testEnvironment();
