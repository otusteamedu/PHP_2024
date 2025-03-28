class Solution {

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */

    function fractionToDecimal($numerator, $denominator) {
        if ($denominator == 0) {
            return "Error: Division by zero";
        }

        if ($numerator == 0) {
            return "0";
        }

        $sign = ($numerator < 0) ^ ($denominator < 0) ? "-" : "";
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $integerPart = intval($numerator / $denominator);
        $remainder = $numerator % $denominator;

        if ($remainder == 0) {
            return $sign . $integerPart;
        }

        $result = $sign . $integerPart . ".";
        $map = [];

        while ($remainder) {
            if (isset($map[$remainder])) {
                $repeatIndex = $map[$remainder];
                return $result . substr($result, strlen($sign) + strlen($integerPart) + 1, $repeatIndex - (strlen($sign) + strlen($integerPart) + 1)) . "(" . substr($result, $repeatIndex) . ")";
            }

            $map[$remainder] = strlen($result);

            $remainder *= 10;
            $result .= intval($remainder / $denominator);
            $remainder %= $denominator;
        }

        return $result;
    }
}