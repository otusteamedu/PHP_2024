<?php

namespace AlexAgapitov\OtusComposerProject;

class Solution
{
    private static array $numbers_chars = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'z', 'y', 'z'],
    ];

    public static function hasCycle(?ListNode $head) : bool
    {
        if ($head->next === null) return false;

        $slow = $head;
        $fast = $head->next;

        while ($fast !== null && $fast->next !== null) {
            if ($slow->val === $fast->val) {
                return true;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }


        return false;
    }

    public static function letterCombinations(string $digits): array
    {
        if (!self::checkLetterCombinationsLength($digits)) return [];

        $ans = [];

        self::recLetterCombinations($digits, 0, $ans);

        return $ans;
    }

    private static function recLetterCombinations(string $digits, int $i, array &$ans, string &$res = null) {
        $n = strlen($digits);

        if ($n === $i) {
            $ans[] = $res;
            return;
        }

        $number = $digits[$i];

        if (!self::checkLetterCombinationsRange($number)) {
            $ans = [];
            return;
        }

        foreach (self::$numbers_chars[$number] AS $char) {
            $res .= $char;
            self::recLetterCombinations($digits, $i + 1, $ans, $res);
            $res = substr($res, 0, -1);
        }
    }

    private static function checkLetterCombinationsLength($digits): bool
    {
        return strlen($digits) <= 4;
    }

    private static function checkLetterCombinationsRange(int $number): bool
    {
        return $number >= 2 && $number <= 9;
    }
}