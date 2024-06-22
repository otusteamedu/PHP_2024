<?php

require __DIR__ . '/vendor/autoload.php';

use Evgenysmrnv\Security\SecurityPatch;

$filename = 'filename example.txt';
$filename = \Evgenysmrnv\Security\SecurityPatch::checkHttpHeader($filename);
echo $httpHeaderExample = 'Content-Disposition: attachment; filename="' . $filename . '"';
