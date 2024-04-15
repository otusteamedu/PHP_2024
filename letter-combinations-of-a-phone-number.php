<?php

declare(strict_types=1);

// Сложность O(4^n)

class Solution
{
    const MAPPING = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];

    public array $result = [];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations(string $digits)
    {
        if (strlen($digits) == 0) {
            return [];
        }

        return $this->backTracking(0, $digits);
    }

    function backTracking($index, $digits, $combine = '')
    {
        foreach (self::MAPPING[$digits[$index]] as $currentSymbol) {
            if (self::MAPPING[$digits[$index + 1]]) {
                $this->backTracking($index + 1, $digits, $combine . $currentSymbol);
            } else {
                $this->result[] = $combine . $currentSymbol;
            }
        }
        return $this->result;
    }
}

var_dump((new Solution())->letterCombinations('22'));