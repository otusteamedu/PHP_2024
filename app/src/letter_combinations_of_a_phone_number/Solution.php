<?php

namespace Dsergei\Hw14\letter_combinations_of_a_phone_number;

class Solution
{
    private const MAP_LETTERS = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z']
    ];

    public function letterCombinations(string $input): array
    {
        $combinations = [];
        if (empty($input)) {
            return $combinations;
        }
        $this->map($input, 0, '', $combinations);
        return $combinations;
    }

    private function map(string $input, int $index, string $combination, array &$combinations): void
    {
        if ($index === strlen($input)) {
            $combinations[] = $combination;
            return;
        }

        $letters = self::MAP_LETTERS[$input[$index]];
        foreach ($letters as $letter) {
            $this->map($input, $index + 1, $combination . $letter, $combinations);
        }
    }
}

