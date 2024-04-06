<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw19\ListNode;
use Lrazumov\Hw19\Solution;
use Lrazumov\Hw19\Solution2;

try {
    $solution = (new Solution())
        ->letterCombinations('2');
    var_dump($solution);

    $solution = (new Solution2())
        ->letterCombinations('2');
    var_dump($solution);

    $solution = (new Solution())
        ->letterCombinations('22');
    var_dump($solution);
    $solution = (new Solution2())
        ->letterCombinations('22');
    var_dump($solution);
} catch (\Exception $e) {
    echo $e->getMessage();
}
