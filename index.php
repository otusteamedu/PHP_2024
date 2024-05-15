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
        if ($digitsLength === 1) return $letterMap[$digits[0]];

        $result = [];
        $data = [];
        for ($i = 0; $i < $digitsLength; $i++) {
            $data[] = $letterMap[$digits[$i]];
        }
        $this->mergeLetters($data, $result);
        return $result;
    }


    function mergeLetters(array $lettersArr, &$result)
    {
        $countDigits = count($lettersArr);
        for ($i = 0; $i < $countDigits; $i++) {
            foreach ($lettersArr[$i] as $cur) {
                if ($i + 1 < $countDigits) {
                    foreach ($lettersArr[$i + 1] as $next) {
                        $result[] = $cur . $next;
                    }
                }
            }
            array_shift($lettersArr);
            $this->mergeLetters($lettersArr, $result);
        }
    }
}
