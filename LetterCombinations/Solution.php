<?php

declare(strict_types=1);

namespace PavelMiasnov\Hw14\LetterCombinations;

/**
 * Сложность O(3^N * 4^M), т.к. алгоритм осуществляет перебор N элементов списка с 3 цифрами в составе и M элементов с 4 цифрами в составе.
 * Сложность по памяти: O(3^N * 4^M), т.к. сложность зависит от количества необходимых для хранения комбинаций.
 */

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
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
