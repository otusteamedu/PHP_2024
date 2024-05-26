<?php

class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB): ?ListNode
    {
        if ($headA === null || $headB === null) {
            return null;
        }

        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = $pointerA === null ? $headB : $pointerA->next;
            $pointerB = $pointerB === null ? $headA : $pointerB->next;
        }

        return $pointerA;
    }
}
