<?php

declare(strict_types=1);

namespace Otus\Leetcode\PhoneLetters;

// Сложность O(k^n) - пепребираем число длиной n элементов, для каждого числа n раз перебираем k вариантов символов;
class Solution
{
    /**
     * @return array
     */
    private function getDigitChars(): array
    {
        $result = [];
        for ($i = 2; $i <= 9; $i++) {
            $len = ($i == 7 || $i == 9) ? 4 : 3;
            $shift = $i > 7 ? 1 : 0;
            for ($j = 0; $j < $len; $j++) {
                $result[$i][] = chr(ord('a') + (((int) $i - 2) * 3 + $j) + $shift);
            }
        }
        return $result;
    }

    /**
     * @param string $digits
     * @return string[]
     */
    public function letterCombinations(string $digits): array
    {
        $digitChars = self::getDigitChars();
        $digitsNum = strlen($digits);
        $variants = [];

        for ($i = 0; $i < $digitsNum; $i++) {
            $chars = $digitChars[$digits[$i]];

            if (!isset($variants[$i])) {
                $variants = $chars;
                continue;
            }

            $result = [];
            $variantsNum = count($variants);
            $charsNum = count($chars);
            for ($j = 0; $j < $variantsNum; $j++) {
                for ($k = 0; $k < $charsNum; $k++) {
                    $result[] = $variants[$j] . $chars[$k];
                }
            }

            $variants = $result;
        }

        return $variants;
    }
}
