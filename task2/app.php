<?php

declare(strict_types=1);

use VictoriaBabikova\FractionToDecimal\Solution;

require_once __DIR__ . '/vendor/autoload.php';

$fractionToDecimal = new Solution();

var_dump($fractionToDecimal->fractionToDecimal(22, 7));
