<?php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head)
    {
        if (empty($head) || empty($head->next)) {
            return false;
        }

        $next = $head->next;
        $nextSecond = $head->next->next;
        if ($next === $nextSecond) {
            return true;
        }

        while ($nextSecond && $nextSecond->next) {
            $next = $next->next;
            $nextSecond = $nextSecond->next->next;

            if ($next === $nextSecond) {
                return true;
            }
        }

        return false;
    }
}
