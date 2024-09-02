<?php

declare(strict_types=1);

// Time complexity: O(N)
// Space complexity: O(1)
final class Solution {
    public function mergeTwoLists(?ListNode $a, ?ListNode $b): ?ListNode
    {
        $head = $tail = new ListNode();

        while (isset($a, $b)) {
            if ($a->val < $b->val) {
                $tail->next = $a;

                $a = $a->next;
            } else {
                $tail->next = $b;

                $b = $b->next;
            }

            $tail = $tail->next;
        }

        $tail->next = $a ?? $b;

        return $head->next;
    }
}

final class ListNode {
    function __construct(
        public int $val = 0,
        public ?ListNode $next = null,
    ) {}
}
