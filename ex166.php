<?php

class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal(int $numerator, int $denominator)
    {
        if($denominator == 0) {
            return "-";
        }
        $int = floor($numerator/$denominator);
        $rest = $numerator % $denominator;
        $strDecimal = "";

        while ($rest != 0) {
            $hash[$rest] = true;
            $decimalChunk = intdiv(abs($rest) * 10, abs($denominator));
            $rest = $rest * 10 % $denominator;
            $strDecimal .= $decimalChunk;

            if(isset($hash[$rest])) {
                $strDecimal = "($strDecimal)";
                break;
            }
        }

        return $int . ($strDecimal ? ".".$strDecimal : "");
    }
}
