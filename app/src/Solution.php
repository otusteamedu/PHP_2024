<?php

declare(strict_types=1);

namespace Lrazumov\Hw10;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2): ListNode {
        if ($list1 === null) {
            return $list2;
        }
        elseif ($list2 === null) {
            return $list1;
        }

        $list = null;
        if ($list1->val < $list2->val) {
            $list = $list1;
            $list->next = $this->mergeTwoLists($list1->next, $list2);
        }
        else {
            $list = $list2;
            $list->next = $this->mergeTwoLists($list1, $list2->next);
        }
        return $list;
    }
}
