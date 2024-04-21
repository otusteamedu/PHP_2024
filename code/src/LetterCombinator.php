<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Algorithm;

class LetterCombinator
{
    private const MAP = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z'],
    ];

    public function letterCombinations(string $digits): array
    {
        if ('' === $digits) {
            return [];
        }

        $digitsLength = strlen($digits);
        $prefixes = [''];

        for ($i = 0; $i < $digitsLength; $i++) {
            $newPrefixes = [];

            foreach ($prefixes as $prefix) {
                $lettersLength = count(self::MAP[$digits[$i]]);

                for ($j = 0; $j < $lettersLength; $j++) {
                    $newPrefixes[] = $prefix . self::MAP[$digits[$i]][$j];
                }
            }

            $prefixes = $newPrefixes;
        }

        return $prefixes;
    }
}
