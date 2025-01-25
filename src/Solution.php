<?php

namespace KRudenko\Otus;

class Solution
{
    function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode {
        $l1 = $list1;
        $l2 = $list2;

        if ($l1->val === null) {
            $lCurItem = $l2;
            $l2 = $l2->next;
        } else if ($l2->val === null) {
            $lCurItem = $l1;
            $l1 = $l1->next;
        } else if ($l1->val <= $l2->val) {
            $lCurItem = $l1;
            $l1 = $l1->next;
        } else {
            $lCurItem = $l2;
            $l2 = $l2->next;
        }

        $result = $lCurItem;

        while ($l1 !== null && $l2 !== null) {
            if ($l1->val <= $l2->val) {
                $lCurItem->next = $l1;
                $lCurItem = $l1;
                $l1 = $l1->next;
            } else {
                $lCurItem->next = $l2;
                $lCurItem = $l2;
                $l2 = $l2->next;
            }
        }

        if ($l1 !== null) {
            $lCurItem->next = $l1;
        } else {
            $lCurItem->next = $l2;
        }

        return $result;
    }
}
