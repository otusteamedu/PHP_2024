<?php

declare(strict_types=1);

// https://leetcode.com/problems/letter-combinations-of-a-phone-number/
final class Solution
{
    public function letterCombinations(string $digits): array
    {
        $digitsCount = strlen($digits);

        if ($digitsCount === 0) {
            return [];
        }

        $digitToCharsMap = [
            2 => ['a', 'b', 'c'],
            3 => ['d', 'e', 'f'],
            4 => ['g', 'h', 'i'],
            5 => ['j', 'k', 'l'],
            6 => ['m', 'n', 'o'],
            7 => ['p', 'q', 'r', 's'],
            8 => ['t', 'u', 'v'],
            9 => ['w', 'x', 'y', 'z'],
        ];

        if ($digitsCount === 1) {
            return $digitToCharsMap[$digits[0]];
        }

        $combinations = [''];

        for ($i = 0; $i < $digitsCount; $i++) {
            $digit = $digits[$i];
            $digitChars = $digitToCharsMap[$digit];

            $newCombinations = [];

            foreach ($combinations as $combination) {
                foreach ($digitChars as $char) {
                    $newCombinations[] = $combination . $char;
                }
            }

            $combinations = $newCombinations;
        }

        return $combinations;
    }
}
