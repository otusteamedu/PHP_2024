<?php

declare(strict_types=1);

$nums = [7, -5, 1, 5, -3, 2];

// Сложность O(n)

function maxPrefixSum(array $nums): int {
    $len = count($nums);
    $max = 0;
    $sum = 0;
    for ($i = 0; $i < $len; $i++) {
        $sum += $nums[$i];
        if ($sum > $max) $max = $sum;
    }

    return $max;
}

var_dump(maxPrefixSum($nums));