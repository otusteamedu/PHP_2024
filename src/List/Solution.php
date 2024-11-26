<?php

namespace VladimirGrinko\List;

use VladimirGrinko\List\ListNode;

class Solution
{
    /*
    Сложность O(m+n), где m и n - это длины списков.
    То есть максимальное время выполнения - это сумма длин списков
    */
    public function getIntersectionNode(?ListNode $headA, ?ListNode $headB): ?ListNode
    {
        if ($headA === null || $headB === null) {
            return null;
        }
        
        $idxA = $headA;
        $idxB = $headB;

        while ($idxA !== $idxB) {
            $idxA = ($idxA === null) ? $headB : $idxA->next;
            $idxB = ($idxB === null) ? $headA : $idxB->next;
        }

        return $idxA;
    }
}
