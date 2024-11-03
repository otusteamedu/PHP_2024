<?php

namespace VladimirGrinko\Phone;

class Solution
{
    const KEYBOARD = [
        '2' => "abc",
        '3' => "def",
        '4' => "ghi",
        '5' => "jkl",
        '6' => "mno",
        '7' => "pqrs",
        '8' => "tuv",
        '9' => "wxyz",
    ];

    /*
    Сложность алгоритма O(3^n) или O(4^n), где n - кол-во цифр во входной строке
    */
    public function letterCombinations(string $digits = ''): array
    {
        $res = [];
        for ($i=0; $i < strlen($digits); $i++) {
            $res = $this->createCombination($res, $digits[$i]);
        }
        return $res;
    }

    private function createCombination(array $words, string $number): array
    {
        if (empty($words)) {
            $words = [''];
        }
        $res = [];
        foreach ($words as $word) {
            for ($i = 0; $i < strlen(self::KEYBOARD[$number]); $i++) {
                $letter = self::KEYBOARD[$number][$i];
                $res[] = $word . $letter;
            }
        }
        return $res;
    }
}
