<?php

class Solution
{

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator)
    {
        $result = $numerator / $denominator;
        $formatted = number_format($result, 16);
        $digitsAfterPoint = substr(strrchr($result, '.'), 1);
        $digitsAfterPointCount = strlen($digitsAfterPoint);
        if ($digitsAfterPointCount <= 6) {
            var_dump('low count');
            return (string)$result;
        }

        $firstSymbol = null;
        $firstPart = '';
        $secondPart = '';
        $firstPartWithoutEqual = '';
        $secondPartWithoutEqual = '';
        $isFirstPartFinished = false;
        $isFractionEqual = false;
        $isFractionDuplicate = false;
        $lastDigit = null;
        $lastDigitDuplicateTimes = 0;

        foreach (str_split($digitsAfterPoint) as $digitAfterPoint) {
            if ($digitAfterPoint === $firstSymbol && $isFirstPartFinished && $digitAfterPoint !== $lastDigit) {
                $isFractionEqual = $firstPart === $secondPart;
                break;
            }
            if ($digitAfterPoint === $firstSymbol && $digitAfterPoint !== $lastDigit) {
                $isFirstPartFinished = true;
            }
            if ($firstSymbol === null) {
                $firstSymbol = $digitAfterPoint;
            }

            if (!$isFirstPartFinished && !$isFirstPartFinished) {
                $firstPart .= $digitAfterPoint;
            } else {
                $secondPart .= $digitAfterPoint;
            }

            if ($lastDigit === $digitAfterPoint) {
                if ($lastDigitDuplicateTimes++ > 5) {
                    $secondPartWithoutEqual = $digitAfterPoint;
                    $isFractionDuplicate = true;
                    $firstPartWithoutEqual = substr($firstPartWithoutEqual, 0, -1);
                    break;
                }
            } else {
                $firstPartWithoutEqual .= $digitAfterPoint;
            }

            $lastDigit = $digitAfterPoint;
        }

        if ($isFractionEqual) {
            $result = "0.({$firstPart})";
        } elseif ($isFractionDuplicate) {
            $result = "0.{$firstPartWithoutEqual}({$secondPartWithoutEqual})";
        }

        return $result;
    }
}
