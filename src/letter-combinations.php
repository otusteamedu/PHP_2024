<?php

declare(strict_types=1);

class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $map = [
            0 => '',
            1 => '',
            2 => 'abc',
            3 => 'def',
            4 => 'ghi',
            5 => 'jkl',
            6 => 'mno',
            7 => 'pqrs',
            8 => 'tuv',
            9 => 'wxyz'
        ];

        $strs = array_reduce(
            str_split($digits),
            static function ($s, $d) use ($map) {
                $s[] = $map[$d];
                return $s;
            },
            []
        );

        return $this->concat($strs);
    }

    function concat($strs, $prefix = "")
    {
        $str = array_shift($strs);
        $res = [];
        if (empty($strs)) {
            foreach (str_split($str) as $char) {
                $res[] = $prefix . $char;
            }
            return $res;
        }

        foreach (str_split($str) as $char) {
            $res = array_merge($res, $this->concat($strs, "$prefix$char"));
        }
        return $res;
    }
}