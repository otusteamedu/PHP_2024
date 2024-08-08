<?php

declare(strict_types=1);

class Solution
{

    //Time complexity: O(3N × 4M), где N - количество цифр с тремя соответствующими буквами,
    // а M - количество цифр с четырьмя соответствующими буквами.
    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits)
    {
        if (empty($digits)) {
            return [];
        }

        $digitToCharMap = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        ];

        $combinations = [''];
        $n = strlen($digits);

        for ($i = 0; $i < $n; $i++) {
            $newCombinations = [];
            $letters = $digitToCharMap[$digits[$i]];

            foreach ($combinations as $combination) {
                foreach ($letters as $letter) {
                    $newCombinations[] = $combination . $letter;
                }
            }

            $combinations = $newCombinations;
        }

        return $combinations;
    }
}

