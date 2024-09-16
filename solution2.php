<?php

class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $data = [];

        $result = [];
        $char = 'a';
        for ($i = 2; $i <= 9; $i++) {
            $len = ($i === 7 || $i === 9) ? 4 : 3;

            for ($j = 0; $j < $len; $j++) {
                $data[$i][$j] = $char;
                $char++;
            }
        }

        $lenDigits = strlen($digits);
        for ($i = 0; $i < $lenDigits; $i++) {
            $digit = $digits[$i];
            if (count($result) === 0){
                $result = [""];
            }
            $chars = $data[$digit];
            $temp = [];
            for ($j = 0; $j < count($chars); $j++) {
                foreach ($result as $item) {
                    $temp[] = $item . $chars[$j];
                }
            }

            $result = $temp;
        }

        return $result;
    }
}