<?php

declare(strict_types=1);

use Evgenyart\Hw19\SolutionFractionToRecurringDecimal;

require_once(__DIR__ . '/vendor/autoload.php');

$solution = new SolutionFractionToRecurringDecimal();

$numerator = 4;
$denominator = 333;

$result = $solution->fractionToDecimal($numerator, $denominator);

var_dump($result);
