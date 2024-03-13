<?php

namespace Dsergei\Hw8;

class Solution
{
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ListNode
    {
        if (is_null($list1) && is_null($list2)) {
            return new ListNode(null);
        }

        if (is_null($list1)) {
            return $list2;
        }

        if (is_null($list2)) {
            return $list1;
        }

        $countNodesList1 = $this->getCountNodes($list1);
        $countNodesList2 = $this->getCountNodes($list2);

        if ($countNodesList1 > 50) {
            if ($countNodesList2 > 50) {
                return new ListNode(null);
            } else {
                return $list2;
            }
        }

        $checkLimitValueList1 = $this->isLimitExceededValue($list1->val);
        $checkLimitValueList2 = $this->isLimitExceededValue($list2->val);

        if ($checkLimitValueList1) {
            if ($checkLimitValueList2) {
                return new ListNode(null);
            } else {
                return $list2;
            }
        }

        if ($list1->val < $list2->val) {
            $list = $list1;
            $list->next = $this->mergeTwoLists($list1->next, $list2);
        } else {
            $list = $list2;
            $list->next = $this->mergeTwoLists($list1, $list2->next);
        }

        return $list;
    }

    private function getCountNodes(ListNode $list)
    {
        $count = 0;
        while (!is_null($list)) {
            $count++;
            $list = $list->next;
        }

        return $count;
    }

    private function isLimitExceededValue(int $value)
    {
        return $value > 100 || $value < -100;
    }
}