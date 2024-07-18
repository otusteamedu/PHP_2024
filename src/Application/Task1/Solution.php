<?php

namespace EkaterinaKonyaeva\OtusComposerApp\Application\Task1;

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        if (strlen($digits) == 0) {
            return [];
        }

        $map = [
            '2' => 'abc',
            '3' => 'def',
            '4' => 'ghi',
            '5' => 'jkl',
            '6' => 'mno',
            '7' => 'pqrs',
            '8' => 'tuv',
            '9' => 'wxyz'
        ];

        $result = [''];

        for ($i = 0; $i < strlen($digits); $i++) {
            $result = $this->combine($result, str_split($map[$digits[$i]]));
        }

        return $result;
    }

    function combine($arr1, $arr2) {
        $result = [];
        foreach ($arr1 as $item1) {
            foreach ($arr2 as $item2) {
                $result[] = $item1 . $item2;
            }
        }
        return $result;
    }
}