<?php

namespace \Kyberlox\solution;

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
        };

        $buttons = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        ];
        $combinations = [''];

        for ($i = 0; $i < strlen($digits); $i++) {
            $current_combination = [];
            foreach ($combinations as $combination) {
                foreach (str_split($digits[$i]) as $number) {
                    $number = (int) $number;
                    foreach ($buttons[$number] as $letter) {
                        $current_combination[] = $combination . $letter;
                    }
                }
            }
            $combinations = $current_combination;
        }

        return $combinations;
    }
}
