<?php

class ListNode
{
    public int $val = 0;
    public ?self $next = null;

    function __construct($val)
    {
        $this->val = $val;
    }
}

/**
 * Time: O (n + m)
 * Space: O (1)
 */
class Solution
{
    function getIntersectionNode(ListNode $headA, ListNode $headB): ListNode
    {
        $a = $headA;
        $b = $headB;

        while ($a !== $b) {
            if ($a === null) {
                $a = $headB;
            } else {
                $a = $a->next;
            }

            if ($b === null) {
                $b = $headA;
            } else {
                $b = $b->next;
            }
        }

        return $a;
    }
}