<?php

declare(strict_types=1);

namespace Lrazumov\Hw19;

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $digits_number = strlen($digits);
        $combinations = [];
        for ($i = 0; $i < $digits_number; $i++) {
            $letters = $this->getLetters(
                (int) $digits[$i]
            );
            if (empty($combinations)) {
                $combinations = $letters;
                continue;
            }
            $multiplication = [];
            foreach ($letters as $letter) {
                foreach ($combinations as $combination) {
                    $multiplication[] = $combination . $letter;
                }
            }
            $combinations = $multiplication;
        }
        return $combinations;
    }

    private function getLetters(int $number): array
    {
        return match ($number) {
            2 => ['a', 'b', 'c'],
            3 => ['d', 'e', 'f'],
            4 => ['g', 'h', 'i'],
            5 => ['j', 'k', 'l'],
            6 => ['m', 'n', 'o'],
            7 => ['p', 'q', 'r', 's'],
            8 => ['t', 'u', 'v'],
            9 => ['w', 'x', 'y', 'z']
        };
    }
}
