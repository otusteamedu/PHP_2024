<?php

declare(strict_types=1);

class SolutionTask2
{
    /**
     * Return all possible letter combinations that the phone number digits could represent.
     *
     * @param string $digits
     * @return string[]
     */
    function letterCombinations(string $digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $digitToLetters = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        ];

        $result = [''];

        foreach (str_split($digits) as $digit) {
            $temp = [];
            foreach ($result as $combination) {
                foreach ($digitToLetters[$digit] as $letter) {
                    $temp[] = $combination . $letter;
                }
            }
            $result = $temp;
        }

        return $result;
    }
}
