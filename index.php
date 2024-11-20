<?php
declare(strict_types=1);

// Leetcode task 141
class ListNode {
    public int $val = 0;
    public ListNode|null $next = null;
    function __construct($val) {
        $this->val = $val;
        $this->next = null;
    }
}

/**
 * @param ListNode $head
 * @return Boolean
 */
function hasCycle(ListNode $head): bool
{
    $slow = $head;
    $fast = $head;
    while ($fast!== null && $fast->next!== null) {
        $slow = $slow->next;
        $fast = $fast->next->next;

        if ($slow === $fast) {
            return true;
        }
    }
    return false;
}


// Leetcode task 17


class Solution
{

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations(string $digits): array
    {
        $letterMap = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $digitsLength = strlen($digits);
        if ($digitsLength === 0) return [];
        if ($digitsLength === 1) return $letterMap[$digits[0]];

        $result = [];
        $data = [];
        for ($i = 0; $i < $digitsLength; $i++) {
            $data[] = $letterMap[$digits[$i]];
        }
        $this->mergeLetters($data, $result);
        return $result;
    }

    function mergeLetters(array $lettersArr,&$result, int $param = 0)
    {
        for ($f = 0; $f < count($lettersArr[$param]); $f++) {
            $level = $param;
            $word = $lettersArr[$level][$f];
            if ($level+1 < count($lettersArr)) {
                $level++;
                for ($n = 0; $n < count($lettersArr[$level]); $n++) {
                    $word .= $lettersArr[$level][$n];
                    if ($level+1 < count($lettersArr)) {
                        $level++;
                        for ($nn = 0; $nn < count($lettersArr[$level]); $nn++) {
                            $word .= $lettersArr[$level][$nn];
                            if ($level+1 < count($lettersArr)) {
                                $level++;
                                for ($nnn = 0; $nnn < count($lettersArr[$level]); $nnn++) {
                                    $word .= $lettersArr[$level][$nnn];
                                    $result[] = $word;
                                    $word = substr($word, 0, -1);
                                }
                                $level--;
                            } else $result[] = $word;
                            $word = substr($word, 0, -1);
                        }
                        $level--;
                    } else $result[] = $word;
                    $word = substr($word, 0, -1);
                }
            } else $result[] = $word;
        }
    }
}