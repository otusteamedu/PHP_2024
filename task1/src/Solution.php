<?php

declare(strict_types=1);

namespace VictoriaBabikova\IntersectionNode;

class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ListNode
    {
        $sorted_listA = $headA;
        $sorted_listB = $headB;

        while ($sorted_listA !== $sorted_listB) {
            $sorted_listA = $sorted_listA === null ? $headB : $sorted_listA->next;
            $sorted_listB = $sorted_listB === null ? $headA : $sorted_listB->next;
        }

        return $sorted_listA;
    }
}
