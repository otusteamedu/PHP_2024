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
    public function hasCycle(ListNode $head): bool
    {
        $stack = [];
        while (!is_null($head)) {
            if (in_array(spl_object_id($head), $stack, true)) {
                return true;
            }

            $stack[] = spl_object_id($head);
            $head = $head->next;
        }
        return false;

    }
}
