<?php

namespace sd;

class Solution
{
    protected array $digitsDictionary = [
        1 => [],
        2 => [
            'a',
            'b',
            'c',
        ],
        3 => [
            'd',
            'e',
            'f',
        ],
        4 => [
            'g',
            'h',
            'i',
        ],
        5 => [
            'j',
            'k',
            'l',
        ],
        6 => [
            'm',
            'n',
            'o',
        ],
        7 => [
            'p',
            'q',
            'r',
            's',
        ],
        8 => [
            't',
            'u',
            'v',
        ],
        9 => [
            'w',
            'x',
            'y',
            'z',
        ],
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits)
    {
        $digitsArray = str_split($digits);
        $symbolsArray = [];
        foreach ($digitsArray as $digit) {
            $symbolsArray[] = $this->digitsDictionary[$digit];
        }

        return $this->combinations($symbolsArray);
    }

    public function combinations($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return [];
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = $this->combinations($arrays, $i + 1);
        $result = [];

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = $v . $t;
            }
        }

        return $result;
    }
}
