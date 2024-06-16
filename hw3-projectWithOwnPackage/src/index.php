<?php

require __DIR__ . '/../vendor/autoload.php';

$randomGenerator = new \Ulolop\RandomPackage\RandomGenerator();

$length = 8;
$hex = $randomGenerator->hex($length);
$string = $randomGenerator->string($length);
$password = $randomGenerator->password($length);

echo ($hex . "<br>" . $string . "<br>" . $password);
