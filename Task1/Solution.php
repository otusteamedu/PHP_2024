<?php

declare(strict_types=1);

namespace Task1;
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
    function getIntersectionNode($headA, $headB)
    {
        if (is_null($headA) || is_null($headB)) {
            return null;
        }

        $ptrA = $headA;
        $ptrB = $headB;

        while ($ptrA !== $ptrB) {
            $ptrA = is_null($ptrA) ? $headB : $ptrA->next;
            $ptrB = is_null($ptrB) ? $headA : $ptrB->next;
        }

        return $ptrA;
    }
}
