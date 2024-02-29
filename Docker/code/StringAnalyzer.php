<?php

class StringAnalyzer
{
    public function checkBrackets(string $string): bool
    {
        $strArr = str_split($string);
        $iMax = strlen($string);
        //Можно было бы использовать проверку на вхождение любых символов кроме ( и )
        //Да и в целом переписать чтоб это выглядело адекватно :)
        while(true) {
            if (count($strArr) === 0) {
                break;
            }
            $closeBranch = 0;
            if ($strArr[0] === '(') {
                for ($j = 0; $j < $iMax; $j++) {
                    if ($strArr[$j] === ')') {
                        $closeBranch = $j;
                        break;
                    }
                }
                unset($strArr[0], $strArr[$closeBranch]);
                $strArr = array_values($strArr);
            } else {
                return false;
            }
        }
        return true;
    }
}