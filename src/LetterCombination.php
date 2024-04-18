<?php

declare(strict_types=1);

namespace Alogachev\Homework;

class LetterCombination
{
    public function letterCombinations($digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $phoneKeyboard = [
            2 => 'abc',
            3 => 'def',
            4 => 'ghi',
            5 => 'jkl',
            6 => 'mno',
            7 => 'pqrs',
            8 => 'tuv',
            9 => 'wxyz',
        ];

        $combinations = [];
        $this->generateCombinations($phoneKeyboard, $digits, 0, '', $combinations);

        return $combinations;
    }

    private function generateCombinations($phoneKeyboard, $digits, $index, $current, &$combinations): void
    {
        if ($index === strlen($digits)) {
            $combinations[] = $current;
            return;
        }

        $letters = $phoneKeyboard[$digits[$index]];
        for ($i = 0; $i < strlen($letters); $i++) {
            $this->generateCombinations(
                $phoneKeyboard,
                $digits,
                $index + 1,
                $current . $letters[$i],
                $combinations
            );
        }
    }
}
