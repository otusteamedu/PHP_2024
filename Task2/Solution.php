<?php

namespace Task2;

class Solution
{
    private $map = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {
        if (empty($digits)) {
            return [];
        }

        $combs = $this->map[$digits[0]];
        $n = strlen($digits);
        for ($i = 1; $i < $n; $i++) {
            $newCombs = [];
            $letters = $this->map[$digits[$i]];
            foreach ($letters as $letter) {
                foreach ($combs as $comb) {
                    $newCombs[] = $comb . $letter;
                }
            }
            $combs = $newCombs;
        }

        return $combs;
    }
}
