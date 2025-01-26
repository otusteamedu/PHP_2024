<?php

use Den\Php2024\SolutionLetterCombinations;

require_once __DIR__ . '/vendor/autoload.php';

try {
    echo SolutionLetterCombinations::letterCombinations('223') . PHP_EOL;
    echo SolutionLetterCombinations::letterCombinations('') . PHP_EOL;
    echo SolutionLetterCombinations::letterCombinations('2') . PHP_EOL;
} catch (Exception $exception) {
    echo 'Ошибка: ' . $exception->getMessage() . PHP_EOL;
}
