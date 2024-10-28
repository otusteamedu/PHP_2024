<?php

declare(strict_types=1);

// https://leetcode.com/problems/linked-list-cycle/
final class Solution
{
    function hasCycle(?ListNode $head): bool
    {
        $slow = $head;
        $fast = $head;

        while ($fast) {
            $slow = $slow->next;
            $fast = $fast->next?->next;

            if (null === $fast) {
                break;
            }

            if ($slow === $fast) {
                return true;
            }
        }

        return false;
    }
}

final class ListNode
{
    function __construct(
        public $val = 0,
        public $next = null
    ) {}
}
