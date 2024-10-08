<?php

declare(strict_types=1);

use Evgenyart\Hw14\SolutionLetterCombinations;

require_once(__DIR__ . '/vendor/autoload.php');

$digits = 23;

$SolutionLetterCombinations = new SolutionLetterCombinations();
$result = $SolutionLetterCombinations->letterCombinations($digits);

print_r($result);
