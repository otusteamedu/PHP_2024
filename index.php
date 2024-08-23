<?php
require 'vendor/autoload.php';

use AlexAgapitov\OtusComposerPackage\Common;

$c = Common::getSum(1, 2);

var_dump($c);