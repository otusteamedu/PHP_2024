<?php

namespace TBublikova\Solutions;

class TwoLinkedListsSolution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode($headA, $headB)
    {
        if ($headA === null || $headB === null) {
            return null;
        }

        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = ($pointerA === null) ? $headB : $pointerA->next;
            $pointerB = ($pointerB === null) ? $headA : $pointerB->next;
        }

        return $pointerA;
    }
}
