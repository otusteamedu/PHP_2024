<?php

declare(strict_types=1);

// Time complexity: O(n)
// Space complexity: O(m+n)
final class Solution {
    public function mergeTwoLists(?ListNode $a, ?ListNode $b): ?ListNode
    {
        if (null === $a) {
            return $b;
        }

        if (null === $b) {
            return $a;
        }

        if ($a->val < $b->val) {
            $a->next = $this->mergeTwoLists($a->next, $b);

            return $a;
        } else {
            $b->next = $this->mergeTwoLists($b->next, $a);

            return $b;
        }
    }
}

final class ListNode {
    function __construct(
        public int $val = 0,
        public ?ListNode $next = null,
    ) {}
}
