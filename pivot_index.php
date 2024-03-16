<?php

function pivotIndex(array $nums): int
{
    $left_index = 0;
    $right_index = count($nums) - 1;
    $left = abs($nums[$left_index]);
    $right = abs($nums[$right_index]);

    while ($left_index < $right_index) {
        if ($left > $right) {
            $right_index--;
            $right += abs($nums[$right_index]);
        } else {
            $left_index++;
            $left += abs($nums[$left_index]);
        }
    }

    return $left == $right ? $left_index : -1;
}

$nums = [1,7,3,6,2,6];
$assert = -1;
$res = pivotIndex($nums);
$test = "Test 1";
if ($assert === $res) {
    echo "{$test} success\n";
} else {
    echo "{$test} fail assert: {$assert} --- res: {$res}\n";
}

$nums = [1,7,3,6,5,6];

$assert = 3;
$res = pivotIndex($nums);
$test = "Test 2";
if ($assert === $res) {
    echo "{$test} success\n";
} else {
    echo "{$test} fail assert: {$assert} --- res: {$res}\n";
}


$nums = [1,2,1];
$assert = 1;
$res = pivotIndex($nums);
$test = "Test 3";
if ($assert === $res) {
    echo "{$test} success\n";
} else {
    echo "{$test} fail assert: {$assert} --- res: {$res}\n";
}

$nums = [1];
$assert = 0;
$res = pivotIndex($nums);
$test = "Test 4";
if ($assert === $res) {
    echo "{$test} success\n";
} else {
    echo "{$test} fail assert: {$assert} --- res: {$res}\n";
}

$nums = [0,0];

$assert = 1;
$res = pivotIndex($nums);
$test = "Test 5";
if ($assert === $res) {
    echo "{$test} success\n";
} else {
    echo "{$test} fail assert: {$assert} --- res: {$res}\n";
}

$nums = [0,0,3,0,0];
$assert = 2;
$res = pivotIndex($nums);
$test = "Test 6";
if ($assert === $res) {
    echo "{$test} success\n";
} else {
    echo "{$test} fail assert: {$assert} --- res: {$res}\n";
}

$nums = [1,7,3,-6,2,-6,11];
$assert = 4;
$res = pivotIndex($nums);
$test = "Test 7";
if ($assert === $res) {
    echo "{$test} success\n";
} else {
    echo "{$test} fail assert: {$assert} --- res: {$res}\n";
}