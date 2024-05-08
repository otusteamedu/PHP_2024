<?php


class Solution
{

    public function letterCombinations($digits)
    {
        if (!$digits) {
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

        $result = [''];
        $max = strlen($digits);
        for ($i = 0; $i < $max; $i++) {
            $tmp = [];
            foreach ($result as $combination) {
                foreach ($letters[$digits[$i]] as $item) {
                    $tmp[] = $combination . $item;
                }
                $result = $tmp;
            }
        }
        return $result;
    }
}
