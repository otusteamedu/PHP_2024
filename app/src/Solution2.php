<?php

declare(strict_types=1);

namespace Lrazumov\Hw19;

class Solution2
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
        $letters_sets = array_map(
            [$this, 'getLetters'],
            str_split($digits)
        );
        return $this->getCombinations(
          array_shift($letters_sets),
          $letters_sets
        );
    }

    private function getCombinations(
        array $combinations,
        array $letters_sets
    ): array
    {
        if (empty($letters_sets)) {
            return $combinations;
        }
        $letters = array_shift($letters_sets);
        $multiplicaion = [];
        foreach ($combinations as $combination) {
            foreach ($letters as $letter) {
                $multiplicaion[] = $combination . $letter;
            }
        }
        return $this->getCombinations($multiplicaion, $letters_sets);
    }

    private function getLetters(string $number): array
    {
        return match ($number) {
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        };
    }
}
