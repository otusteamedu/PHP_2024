<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Phone;

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits): array
    {
        $n = strlen($digits);
        if ($n === 0) {
            return [];
        }

        $map = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $letters = $map[$digits[0]];
        for ($i = 1; $i < $n; $i++) {
            $newLetters = $map[$digits[$i]];
            $lastCount = count($letters);
            $newCount = $lastCount * count($newLetters);
            for ($j = $lastCount; $j < $newCount; $j++) {
                $letters[$j] = $letters[$j - $lastCount];
            }
            $k = 0;
            $l = 0;
            for ($j = 0; $j < $newCount; $j++) {
                $k++;
                $letters[$j] .= $newLetters[$l];
                if ($k === $lastCount) {
                    $k = 0;
                    $l++;
                }
            }
        }

        return $letters;
    }
}
