<?php

declare(strict_types=1);

namespace App;

class PhoneLetterCombinationSolution
{
    public static array $keyMap = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];

    public static function phoneLetterCombinations(string $digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $length = strlen($digits);
        $combinations = [''];

        for ($i = 0; $i < $length; $i++) {
            $newCombinations = [];
            $letters = static::$keyMap[$digits[$i]];

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
