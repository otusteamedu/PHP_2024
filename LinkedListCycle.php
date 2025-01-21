<?php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        if (empty($head))
            return false;

        // Using Floyd's tortoise and hare cycle-finding algorithm
        $tortoise = $head;
        $hare = $head->next;

        while ($tortoise !== $hare && $tortoise !== null && $hare !== null) {
            $tortoise = $tortoise->next;
            $hare = $hare->next->next ?? null;
        }
        if ($tortoise === $hare)
            return true;

        return false;
    }
}
