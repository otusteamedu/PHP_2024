<?php

declare(strict_types=1);

// https://leetcode.com/problems/intersection-of-two-linked-lists
final class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     *
     * @return ListNode
     */
    function getIntersectionNode(mixed $headA, mixed $headB): mixed
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

final class ListNode
{
    public function __construct(
        public $val = 0,
        public $next = null
    ) {}
}
