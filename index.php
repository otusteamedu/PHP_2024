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

function letterCombinations(string $digits): array
{
    $letterMap = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r','s'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z'],
    ];

    $digitsLength = strlen($digits);
    $result = [];
    for ($i = 0; $i < $digitsLength; $i++) {
        foreach ($letterMap[$digits[$i]] as $letArrHead) {
            if ($digitsLength === 1) $result[] = $letArrHead;
            for ($j = $i+1; $j < $digitsLength; $j++) {
                foreach ($letterMap[$digits[$j]] as $letArrTail) {
                    $result[] = $letArrHead. $letArrTail;
                }
            }
        }
    }
    return $result;
}
