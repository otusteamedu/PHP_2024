<?php

namespace KRudenko\Otus\LetterCombinationsOfAPhoneNumber;

class Solution
{
    /**
     * @return string[]
     */
    public function letterCombinations(string $digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $digitMap = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $letters = [];
        for ($i = 0; $i < strlen($digits); $i++) {
            $currentDigit = $digits[$i];
            if (isset($digitMap[$currentDigit])) {
                $letters[] = $digitMap[$currentDigit];
            }
        }

        if (empty($letters)) {
            return [];
        }
        if (count($letters) === 1) {
            return $letters[0];
        }

        $count = count($letters);
        return $this->backtrack($letters, [], $count, 0, []);
    }

    private function backtrack(array $letters, array $path, int $count, int $index, $result): array
    {
        if ($index === $count) {
            $result[] = implode('', $path);
            return $result;
        }

        $current_digit = $letters[$index];
        foreach ($current_digit as $letter) {
            $newPath = $path;
            $newPath[] = $letter;
            $result = $this->backtrack($letters, $newPath, $count, $index + 1, $result);
        }

        return $result;
    }
}
