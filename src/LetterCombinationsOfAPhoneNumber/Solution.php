<?php

namespace KRudenko\Otus\LetterCombinationsOfAPhoneNumber;

class Solution
{
    /**
     * @return string[]
     */
    function letterCombinations(string $digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $digitMap = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $result = [''];

        for ($i = 0; $i < strlen($digits); $i++) {
            $currentDigit = $digits[$i];
            $letters = $digitMap[$currentDigit];
            $temp = [];

            foreach ($result as $combination) {
                for ($j = 0; $j < count($letters); $j++) {
                    $temp[] = $combination . $letters[$j];
                }
            }

            $result = $temp;
        }

        return $result;
    }
}
