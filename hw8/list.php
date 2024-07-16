<?php

namespace HW8;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {

        $result = new ListNode();
        $first = $result;
        while (isset($list1, $list2)) {
            if ($list1->val < $list2->val) {
                $result->next = $list1;
                $list1 = $list1->next;
            } else {
                $result->next = $list2;
                $list2 = $list2->next;
            }
            $result = $result->next;
        }
        $result->next = $list1 ?? $list2;
        return $first->next;
    }
}
