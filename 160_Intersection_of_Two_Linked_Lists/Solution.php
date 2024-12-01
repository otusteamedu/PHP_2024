<?php

declare(strict_types=1);

namespace IntersectionLinkedLists;

class Solution
{
    public function getIntersectionNode(?ListNode $headA, ?ListNode $headB): ?ListNode
    {
        $aPointer = $headA;
        $bPointer = $headB;

        while ($aPointer !== $bPointer) {
            $aPointer = $aPointer ? $aPointer->next : $headB;
            $bPointer = $bPointer ? $bPointer->next : $headA;
        }

        return $aPointer;
    }
}

// Сложность O(n) т.к зависит от длины списков
