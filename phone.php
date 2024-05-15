<?php

class Solution
{

    private const LETTERS = [
        2 => [
            "a",
            "b",
            "c"
        ],
        3 => [
            "d",
            "e",
            "f"
        ],
        4 => [
            "g",
            "h",
            "i"
        ],
        5 => [
            "j",
            "k",
            "l"
        ],
        6 => [
            "m",
            "n",
            "o"
        ],
        7 => [
            "p",
            "q",
            "r",
            "s"
        ],
        8 => [
            "t",
            "u",
            "v"
        ],
        9 => [
            "w",
            "x",
            "y",
            "z"
        ]
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $length = strlen($digits);

        $combination = self::LETTERS[$digits[0]] ?? [];
        if ($length === 1) {
            return $combination;
        }

        for ($i = 1; $i < $length; ++$i) {
            $data = [];
            $nextCombination = self::LETTERS[$digits[$i]] ?? [];
            foreach ($nextCombination as $b) {
                foreach ($combination as $a) {
                    $data[] = $a . $b;
                }
            }

            $combination = $data;
        }

        return $combination;
    }
}
