<?php

function hasCycle($head)
{
    $slow = $head;
    $fast = $head;

    while ($fast && $fast->next) {
        $slow = $slow->next;
        $fast = $fast->next->next;

        if ($slow === $fast)
        {
            return true;
        }

    }

    return false;
}

function letterCombinations($digits)
{
    if (empty($digits)) {
        return [];
    }

    static $phoneMap = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z']
    ];

    $digits = str_split($digits);

    $func = static function ($combination, $nextDigits, &$result) use (&$func, $phoneMap) {
        if (empty($nextDigits)) {
            $result[] = $combination;
        } else {
            $digit = array_shift($nextDigits);
            $letters = $phoneMap[$digit];
            foreach ($letters as $letter) {
                $func($combination . $letter, $nextDigits, $result);
            }
        }
    };

    $result = [];
    $func("", $digits, $result);
    return $result;
}
