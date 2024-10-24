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
        $after = $head;
        $before = $head->next;

        while ($before != null)
        {
            $next = $before->next;

            if ($next == null) {
                return false;
            }

            if ($after === $before || $after === $next) {
                return true;
            }

            $before = $next;
            $after = $after->next;
            $before = $before->next;
        }

        return false;
    }
}
