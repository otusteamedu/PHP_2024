<?php
declare(strict_types=1);

/**
 * Definition for a singly-linked list.
 */
class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val,$next) {
        $this->val = $val;
        $this->next = $next;
    }
 }


class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        if ($headA === null || $headB === null) {
            return null;
        }

        $a = $headA;
        $b = $headB;
        $count = 0;
        while ($a !== $b) {

            if ($a === null) {
                $a = $headB;
                $count++;
            }
            if ($b === null) {
                $b = $headA;
                $count++;
            }
            $a = $a->next;
            $b = $b->next;
            if ($count > 2) {
                return null;
            }
        }
        return $a;
    }
}

