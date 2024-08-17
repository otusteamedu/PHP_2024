<?php

namespace Otus;

class Solution2
{
    private array $digitCharMap = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z']
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {
        if (empty($digits)) {
            return [];
        }

        $symbols = [];
        $words = [];

        $length = strlen($digits);

        for ($i = 0; $i < $length; $i++) {
            $symbols[] = $this->digitCharMap[$digits[$i]];
        }

        foreach ($symbols as $symbolDigits) {
            $words = $this->combineWords($words, $symbolDigits);
        }

        return $words;
    }

    private function combineWords(array $currentWords, array $newSymbols): array
    {
        $combinedWords = [];

        if (empty($currentWords)) {
            return $newSymbols;
        }

        foreach ($currentWords as $word) {
            foreach ($newSymbols as $symbol) {
                $combinedWords[] = $word . $symbol;
            }
        }

        return $combinedWords;
    }
}
