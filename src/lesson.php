<?php

declare(strict_types=1);


class Solution {

    private static $arStrs = [
        "2" => "abc",
        "3" => "def",
        "4" => "ghi",
        "5" => "jkl",
        "6" => "mno",
        "7" => "pqrs",
        "8" => "tuv",
        "9" => "wxyz"
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $digitsCount = strlen($digits);
        $res = [];

        if(!$digitsCount) {
            return $res;
        }

        $hash = [];
        for($i = 0; $i < $digitsCount; $i++) {
            $hash[$i] = 0;
        }

        $isFinished = false;
        while(!$isFinished) {
            $comboItem = "";
            for($i = 0; $i < $digitsCount; $i++) {
                $digit = $digits[$i];
                $symbols = self::$arStrs[$digit];
                $comboItem .= $symbols[$hash[$i]];
            }
            $res[] = $comboItem;

            for ($k = (count($hash)-1); $k>=0; $k--) {
                $digit = $digits[$k];
                if($hash[$k] < (strlen(self::$arStrs[$digit]) - 1)) {
                    $hash[$k]++;
                    break;
                } else {
                    $hash[$k] = 0;
                    if(!isset($hash[$k-1])){
                        $isFinished = true;
                    }
                }
            }
        }
        return $res;
    }
}

$solution = new Solution();
$res = $solution->letterCombinations("237");