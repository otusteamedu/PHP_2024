<?php

namespace Den\Php2024;

use Exception;

class SolutionLetterCombinations
{
    private const LENGTH_LIMIT = 4;

    private static array $comparison = [
        '2' => 'abc',
        '3' => 'def',
        '4' => 'ghi',
        '5' => 'jkl',
        '6' => 'mno',
        '7' => 'pgrs',
        '8' => 'tuv',
        '9' => 'wxyz',
    ];

    public static function letterCombinations(string $digits): string
    {
        if (empty($digits)) {
            return '[]';
        }

        if (!is_numeric($digits)) {
            throw new Exception('Передавать можно строку только с цифрами', 400);
        }

        $maxDigit = max(array_keys(self::$comparison));
        $minDigit = min(array_keys(self::$comparison));
        if (max(str_split($digits)) > $maxDigit || min(str_split($digits)) < $minDigit) {
            throw new Exception(
                "Цифры входящие в сроку должны быть в диапазоне от $minDigit до $maxDigit",
                400
            );
        }


        if (strlen($digits) > self::LENGTH_LIMIT) {
            throw new Exception(
                'Длина строки с цифрами не должна превышать ' . self::LENGTH_LIMIT,
                400
            );
        }

        $result = [];
        self::getCombinations($digits, '', 0, $result);
        return '[' . implode(', ', $result) . ']';
    }

    private static function getCombinations(string $digits, string $current, $i, &$result): void
    {
        if ($i === strlen($digits) && $current !== '') {
            $result[] = $current;
            return;
        }

        $digit = $digits[$i];
        $letters = str_split(self::$comparison[$digit]);

        foreach ($letters as $letter) {
            self::getCombinations($digits, $current . $letter, $i + 1, $result);
        }
    }
}
