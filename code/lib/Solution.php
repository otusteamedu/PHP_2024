<?php
class Solution {

    const COMBINATIONS = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z']
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $digitsLen = strlen($digits);

        $combinations = [];

        if ($digitsLen > 4 || $digitsLen === 0) {
            return $combinations;
        }

        if ($digitsLen === 1) {
            return self::COMBINATIONS[$digits] ?? $combinations;
        }

        for ($i = 0; $i < $digitsLen; $i++)
        {
            $digit = $digits[$i];

            if (!isset(self::COMBINATIONS[$digit])) {
                continue;
            }

            $lettersByDigit = self::COMBINATIONS[$digit];

            $tempRes = [];
            if (empty($combinations)) {
                $combinations = $lettersByDigit;
                continue;
            }

            foreach ($combinations as $combination) {
                foreach ($lettersByDigit as $letter) {
                    $tempRes[] = $combination.$letter;
                }
            }

            $combinations = $tempRes;
        }

        return $combinations;
    }

    function hasCycle(ListNode $head)
    {
        $next = $nextNext = $head;

        while ($nextNext->next != null)
        {
            $next = $next->next;
            $nextNext = $nextNext->next->next;

            if(is_null($next) || is_null($nextNext))
                return false;

            if ($next === $nextNext) {
                return true;
            }
        }

        return false;
    }
}

class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val) {
        $this->val = $val;
    }
}

