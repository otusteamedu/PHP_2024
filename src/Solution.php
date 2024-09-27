<?php

declare(strict_types=1);

namespace hw10;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {
        if ($list1 === null && $list2 === null) {
            return null;
        }

        if ($list1 === null) {
            return $list2;
        }

        if ($list2 === null) {
            return $list1;
        }

        if ($list1->val >= $list2->val) {
            return new ListNode($list2->val, $this->mergeTwoLists($list1, $list2->next));
        }
        return new ListNode($list1->val, $this->mergeTwoLists($list2, $list1->next));
    }
}
