<?php

namespace PHP2024\LinkedList;

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
     * @param ListNode $headxw
     * @return Boolean
     */
    public function hasCycle($head): bool
    {
        if ($head === null || $head->next === null) {
            return false;
        }
        $rabbit = $head;
        $turtle = $head;

        while ($rabbit !== null && $rabbit->next !== null) {
            $rabbit = $rabbit->next->next;
            $turtle = $turtle->next;

            if ($rabbit === $turtle) {
                return true;
            }
        }

        return false;
    }
}
