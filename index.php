<?php

require __DIR__ . '/vendor/autoload.php';

$processor = new \EkaterinaKonyaeva\OtusComposerPackage\MathOperations();
echo $processor->sum(1, 4);
