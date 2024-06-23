<?php

declare(strict_types=1);

namespace Otus\Hw8;

class Solution
{
    /**
     * Алгоритмическая сложность - O(n + m), где
     * n и m - длины двух входных списков
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode|null
     */
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $dummy = new ListNode();
        $current = $dummy;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }

        if ($list1 !== null) {
            $current->next = $list1;
        } elseif ($list2 !== null) {
            $current->next = $list2;
        }

        return $dummy->next;
    }
}
