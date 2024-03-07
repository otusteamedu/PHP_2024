<?php

declare(strict_types=1);

$nums = [1, 7, 3, 6, 5, 6];

// Сложность O(n)
function pivotIndex(array $nums): int
{
    $len = count($nums);
    $copy = $nums;

    $sumLeft = 0;
    $sumRight = array_sum($nums); // Надеюсь тут использование array_sum простительно
    for ($i = 0; $i < $len; $i++) {
        $sumRight -= $copy[$i];

        if ($sumLeft === $sumRight) {
            return $i;
        }

        $sumLeft += $copy[$i];
    }
    return -1;
}

var_dump(pivotIndex($nums));
