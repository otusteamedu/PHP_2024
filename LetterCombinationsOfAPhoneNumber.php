<?php
class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $phone = [
            '2' => 'abc',
            '3' => 'def',
            '4' => 'ghi',
            '5' => 'jkl',
            '6' => 'mno',
            '7' => 'pqrs',
            '8' => 'tuv',
            '9' => 'wxyz',
        ];

        $res = [];
        $len = strlen($digits);

        if ($len == 0) {
            return [];
        } elseif ($len == 1) {
            return str_split($phone[$digits[0]]);
        } else {
            $combinationTail = $this->letterCombinations(substr($digits, 1));
            for ($i = 0; $i < strlen($phone[$digits[0]]); $i++) {
                foreach($combinationTail as $tail) {
                    $res[] = $phone[$digits[0]][$i] . $tail;
                }
            }
        }

        return $res;
    }
}
