<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw19\ListNode;
use Lrazumov\Hw19\Solution;

try {
    $solution = (new Solution())
        ->letterCombinations('23');
    var_dump($solution);

    $solution = (new Solution())
        ->letterCombinations('');
    var_dump($solution);

    $solution = (new Solution())
        ->letterCombinations('2');
    var_dump($solution);
} catch (\Exception $e) {
    echo $e->getMessage();
}
