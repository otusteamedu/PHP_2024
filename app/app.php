<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw29\ListNode;
use Lrazumov\Hw29\Solution;

try {
    $solution = (new Solution())
        ->letterCombinations('2');
    var_dump($solution);

} catch (\Exception $e) {
    echo $e->getMessage();
}
