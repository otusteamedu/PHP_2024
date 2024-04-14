<?php

declare(strict_types=1);

// Сложность O(3^n)

class Solution {

    const MAPPING = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r','s'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $arrays = [];
        for ($i=0; $i < strlen($digits); $i++) {
            $arrays[] = self::MAPPING[$digits[$i]];
        }
        return self::combinations($arrays);
    }

    public static function combinations($arrays) {
        if (empty($arrays)) {
            return [];
        }

        if (count($arrays) === 1) {
            return $arrays[0];
        }

        $topArray = array_pop($arrays);

        $sumOfOtherArrays = self::combinations($arrays);

        $result = [];

        for ($i = 0; $i < count($topArray); $i++) {
            for ($j = 0; $j < count($sumOfOtherArrays); $j++) {
                $result[] = $sumOfOtherArrays[$j] . $topArray[$i];
            }
        }

        return $result;
    }
}