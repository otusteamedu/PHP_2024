<?php

namespace App;

class Solution
{
    public function mergeTwoLists($list1, $list2)
    {
        $current = $mergedList = new ListNode();

        $pointer1 = $list1;
        $pointer2 = $list2;

        while (!empty($pointer1) && !empty($pointer2)) {
            if ($pointer1->val <= $pointer2->val) {
                $current->next = $pointer1;
                $pointer1 = $pointer1->next;
            } else {
                $current->next = $pointer2;
                $pointer2 = $pointer2->next;
            }

            $current = $current->next;
        }

        if (!empty($pointer1)) {
            $current->next = $pointer1;
        } elseif (!empty($pointer2)) {
            $current->next = $pointer2;
        }

        return $mergedList->next;
    }
}
