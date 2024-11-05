<?php

namespace App;

class LetterCombinations
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function getLetterCombinations(string $digits): array
    {
        if ($digits === '') {
            return [];
        }

        $btnArray = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        ];

        $n = strlen($digits);
        if ($n === 1) {
            return $btnArray[$digits[0]];
        }

        $letterCombinations = [''];
        for ($i = 0; $i < $n; $i++) {
            $iterationArray = [];
            $letters = $btnArray[$digits[$i]];

            foreach ($letterCombinations as $combination) {
                foreach ($letters as $letter) {
                    $iterationArray[] = $combination . $letter;
                }
            }

            $letterCombinations = $iterationArray;
        }

        return $letterCombinations;
    }
}
