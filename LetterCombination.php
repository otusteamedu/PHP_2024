<?php

class Solution
{
    // Временная сложность: O(4^n)
    // Пространственная сложность: O(n)
    public function letterCombinations(string $digits): array
    {
        $phoneMap = [
            '2' => 'abc',
            '3' => 'def',
            '4' => 'ghi',
            '5' => 'jkl',
            '6' => 'mno',
            '7' => 'pqrs',
            '8' => 'tuv',
            '9' => 'wxyz'
        ];

        $result = [];

        if ($digits === "") {
            return $result;
        }

        $this->backtrack(0, "", $digits, $phoneMap, $result);

        return $result;
    }

    private function backtrack(int $index, string $path, string $digits, array $phoneMap, array &$result): void
    {
        if ($index === strlen($digits)) {
            $result[] = $path;

            return;
        }

        $letters = $phoneMap[$digits[$index]];

        for ($i = 0; $i < strlen($letters); $i++) {
            $this->backtrack($index + 1, $path . $letters[$i], $digits, $phoneMap, $result);
        }
    }
}
