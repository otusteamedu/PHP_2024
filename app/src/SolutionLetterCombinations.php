<?php

namespace Evgenyart\Hw14;

class SolutionLetterCombinations
{
    const LETTERS = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z']
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {

        if (!strlen($digits)) {
            return [];
        }

        $arDigits = str_split($digits);
        $combinations = [];

        for ($i = 0; $i < count($arDigits); $i++) {
            $lettersDigit = self::LETTERS[$arDigits[$i]];

            if (empty($combinations)) {
                $combinations = $lettersDigit;
                continue;
            }

            $tempResult = [];
            foreach ($combinations as $combination) {
                foreach ($lettersDigit as $oneLetter) {
                    $tempResult[] = $combination . $oneLetter;
                }
            }

            $combinations = $tempResult;
        }
        return $combinations;
    }
}
