<?php

declare(strict_types=1);

namespace Afilipov\Hw18\intersection_two_linked_lists;

class Solution
{
    /**
     * Алгоритмическая сложность - O(n)
     * @param ListNode|null $headA
     * @param ListNode|null $headB
     * @return ListNode|null
     */
    public function getIntersectionNode(?ListNode $headA, ?ListNode $headB): ?ListNode
    {
        if ($headA === null || $headB === null) {
            return null;
        }

        $currentA = $headA;
        $currentB = $headB;

        while ($currentA !== $currentB) {
            $currentA = $currentA === null ? $headB : $currentA->next;
            $currentB = $currentB === null ? $headA : $currentB->next;
        }

        return $currentA;
    }
}
