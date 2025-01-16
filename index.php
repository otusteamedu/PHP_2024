<?php

use KonstantinRudenko\OtusComposerPackage\CalculateCube;

require_once __DIR__ . '/vendor/autoload.php';

$cube = new CalculateCube();

echo $cube->getCube(2.5);
