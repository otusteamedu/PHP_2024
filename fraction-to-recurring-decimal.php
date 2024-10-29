<?php
class Solution {
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator) {
        if ($numerator == 0) return "0"; 

        $result = '';

        
        if (($numerator < 0) ^ ($denominator < 0)) {
            $result .= '-';
        }

        
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        
        $integerPart = intval($numerator / $denominator);
        $result .= $integerPart;

        $remainder = $numerator % $denominator;
        if ($remainder == 0) return $result; 

        $result .= '.'; 

        $remainderMap = [];
        while ($remainder != 0) {
            
            if (isset($remainderMap[$remainder])) {
                $index = $remainderMap[$remainder];
                $result = substr($result, 0, $index) . '(' . substr($result, $index) . ')';
                return $result;
            }

            $remainderMap[$remainder] = strlen($result);
            $remainder *= 10;
            $result .= intval($remainder / $denominator);
            $remainder %= $denominator;
        }

        return $result;
    }
}
