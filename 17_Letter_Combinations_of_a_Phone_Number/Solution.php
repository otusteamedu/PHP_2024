<?php

declare(strict_types=1);

namespace LetterCombination;

class Solution
{
    public function letterCombinations(string $digits): array
    {
        if (strlen($digits) == 0) {
            return [];
        }

        $result = [''];

        $mapping = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        ];

        foreach (str_split($digits) as $digit) {
            $letters = $mapping[$digit];
            $temp = [];

            foreach ($result as $combination) {
                foreach ($letters as $letter) {
                    $temp[] = $combination . $letter;
                }
            }

            $result = $temp;
        }

        return $result;
    }
}

// Сложность O(n) т.к зависит от длины строки
