<?php

declare(strict_types=1);

namespace App;

class Solution
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {

        if (is_null($list1)) {
            return $list2;
        }

        if (is_null($list2)) {
            return $list1;
        }

        if ($list1->val < $list2->val) {
            $list1->next = $this->mergeTwoLists($list1->next, $list2);

            return $list1;
        }

        $list2->next = $this->mergeTwoLists($list1, $list2->next);

        return $list2;
    }
}
