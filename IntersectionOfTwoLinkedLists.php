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
    * @param ListNode $headA
    * @param ListNode $headB
    * @return ListNode
    */
    public function getIntersectionNode($headA, $headB)
    {
        if ($headA === $headB) {
            return $headB;
        }

        $node1 = $headA;
        $node2 = $headB;

        while ($node1 !== $node2) {
            $node1 = $node1 == null ? $headB : $node1->next;
            $node2 = $node2 == null ? $headA : $node2->next;
        }
                
        return $node2;
    }
}
