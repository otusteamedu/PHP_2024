<?php

namespace AlexanderGladkov\LetterCombinations;

class Solution
{
    private array $digitsToLetters = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z'],
    ];

    private array $output = [];
    private int $outputIndex = 0;
    private array $digits  = [];

    /**
     * @param string $digits
     * @return string[]
     */
    public function letterCombinations(string $digits): array
    {
        if ($digits === '') {
            return [];
        }

        $this->digits = str_split($digits);
        $this->processDigit('', 0);
        return $this->output;
    }

    private function processDigit(string $combination, int $digitIndex): void
    {
        $digit = $this->digits[$digitIndex];
        $letters = $this->digitsToLetters[$digit];
        foreach ($letters as $letter) {
            if ($digitIndex < count($this->digits) - 1) {
                $this->processDigit($combination . $letter, $digitIndex + 1);
            } else {
                $this->output[$this->outputIndex++] = $combination . $letter;
            }
        }
    }
}
