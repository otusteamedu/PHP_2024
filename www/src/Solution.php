<?php

namespace Otus;

class Solution
{
    /**
     * O(n+m) - сложжность алгоритма по времени, так как нам необходимо обойти два списка полностью
     * O(1) - сложность по памяти, так как мы используем константное количество памяти
     */
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $dummy = new ListNode(0);
        $tail = $dummy;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val < $list2->val) {
                $tail->next = $list1;
                $list1 = $list1->next;
            } else {
                $tail->next = $list2;
                $list2 = $list2->next;
            }
            $tail = $tail->next;
        }

        if ($list1 !== null) {
            $tail->next = $list1;
        } else {
            $tail->next = $list2;
        }

        return $dummy->next;
    }
}