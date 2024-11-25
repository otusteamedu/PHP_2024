<?php

/**
 * Definition for a singly-linked list.
 *
 * class ListNode {
 *      public $val = 0;
 *      public $next = null;
 *      function __construct($val) { $this->val = $val; }
 *}
 */

class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        if($headA == null || $headB == null) {
            return null;
        }

        $a = $headA;
        $b = $headB;

        while($a !== $b) {
            $a = $a === null ? $headB : $a->next;
            $b = $b === null ? $headA : $b->next;
        }

        return $a;
    }
}
