<?php

declare(strict_types=1);

namespace App;

class Solution
{
    /**
     * @param null|ListNode $list1
     * @param null|ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists(null|ListNode $list1, null|ListNode $list2): ListNode
    {
        if ($list1 == null) {
            return $list2;
        } elseif ($list2 == null) {
            return $list1;
        }
        if ($list1->val < $list2->val) {
            $sorted_list = $list1;
            $sorted_list->next = $this->mergeTwoLists($list1->next, $list2);
        } else {
            $sorted_list = $list2;
            $sorted_list->next = $this->mergeTwoLists($list1, $list2->next);
        }
        return $sorted_list;
    }
}
