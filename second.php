<?php


class Solution
{

    public function letterCombinations($digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $letters = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $result = [];

        $this->recursive($digits, $letters, 0, "", $result);

        return $result;
    }

    private function recursive($digits, $letters, $index, $current, &$result): void
    {
        if ($index === strlen($digits)) {
            $result[] = $current;
            return;
        }

        $digit = $digits[$index];
        foreach ($letters[$digit] as $letter) {
            $this->recursive($digits, $letters, $index + 1, $current . $letter, $result);
        }
    }
}
