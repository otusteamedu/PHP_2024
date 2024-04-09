<?php

declare(strict_types=1);

namespace Afilipov\Hw14\letter_combinations;

class Solution {
    private array $digitMap = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z']
    ];

    /**
     * Алгоритмическая сложность - O(4^n)
     * В худшем случае каждой цифры может может быть 4 буквы, поэтому для каждой цифры будет 4 рекурсивных вызова.
     * @param string $digits
     * @return array
     */
    public function letterCombinations(string $digits): array {
        $result = [];
        if (empty($digits)) {
            return $result;
        }
        $this->recursive($result, '', $digits, 0);
        return $result;
    }

    private function recursive(array &$result, string $current, string $digits, int $index): void {
        if ($index === strlen($digits)) {
            $result[] = $current;
            return;
        }

        $letters = $this->digitMap[$digits[$index]];
        foreach ($letters as $letter) {
            $this->recursive($result, $current . $letter, $digits, $index + 1);
        }
    }
}
