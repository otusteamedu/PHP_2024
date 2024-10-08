<?php

declare(strict_types=1);

namespace Otus\GetIntersectionNode;

// Вычислительная сложность O(N + M), где N и M - длины списков headA и headB.
// В худшем случае алгоритм обойдёт все узлы обоих списков.

// Пространственная сложность O(1) т.к. это простой перебор списков
class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode|null
     */
    function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = $pointerA ? $pointerA->next : $headB;
            $pointerB = $pointerB ? $pointerB->next : $headA;
        }

        return $pointerA;
    }
}
