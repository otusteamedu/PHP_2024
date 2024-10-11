<?php

namespace LetterCombination;

class Solution
{

    /**
     * Сложность O(4ⁿ * n)
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits)
    {
        $letterMapping = [
            "2" => ['a', 'b', 'c'],
            "3" => ['d', 'e', 'f'],
            "4" => ['g', 'h', 'i'],
            "5" => ['j', 'k', 'l'],
            "6" => ['m', 'n', 'o'],
            "7" => ['p', 'q', 'r', 's'],
            "8" => ['t', 'u', 'v'],
            "9" => ['w', 'x', 'y', 'z']
        ];


        $length = strlen($digits);
        if ($length === 0) {
            return [];
        }

        $numbers = str_split($digits);
        $result = $letterMapping[$numbers[0]];

        for ($i = 1; $i < $length; $i++) {
            $newResult = [];
            foreach ($letterMapping[$numbers[$i]] as $newLetter) {
                foreach ($result as $resLet) {
                    $newResult[] = $resLet . $newLetter;
                }
            }
            $result = $newResult;
        }

        return $result;


    }
}