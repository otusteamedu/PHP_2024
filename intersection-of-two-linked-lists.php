<?php

declare(strict_types=1);

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
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        if (!$headA || !$headB)
            return null;

        if ($headA === $headB)
            return $headA;

        while ($headA) {
            $headA->marked = true;
            $headA = $headA->next;
        }

        while ($headB) {
            if ($headB->marked)
                return $headB;
            $headB = $headB->next;
        }
        return null;
    }
}