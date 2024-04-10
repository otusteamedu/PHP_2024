<?php

declare(strict_types=1);

// phpcs:ignore
class Solution
{
    /**
     * @param string $digits
     * @return string[]
     */
    public function letterCombinations(string $digits): array
    {
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

        $combinations = [];

        $this->backtrack($digits, '', 0, $digitMap, $combinations);

        return $combinations;
    }

    /**
     * @param $digits
     * @param $current
     * @param $index
     * @param $digitMap
     * @param $combinations
     * @return void
     */
    private function backtrack($digits, $current, $index, $digitMap, &$combinations)
    {
        if ($index === strlen($digits)) {
            if ($current !== '') {
                $combinations[] = $current;
            }
            return;
        }

        $digit = $digits[$index];
        $letters = $digitMap[$digit];

        foreach ($letters as $letter) {
            $this->backtrack($digits, $current . $letter, $index + 1, $digitMap, $combinations);
        }
    }
}
