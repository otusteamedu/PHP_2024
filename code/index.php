<?php

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

namespace sd;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2): ListNode
    {
        $dummy = new ListNode();
        $current = $dummy;
        $isEmptyLists = $list1?->val === null && $list2?->val === null;

        if ($isEmptyLists) {
            return new ListNode(null);
        }

        while ($list1?->val !== null || $list2?->val !== null) {
            if ($list1?->val !== null && ($list1->val <= $list2->val) || $list2->val === null) {
                $current->next = $list1;
                $list1 = $list1?->next;
            } elseif ($list2?->val !== null) {
                $current->next = $list2;
                $list2 = $list2?->next;
            }

            $current = $current->next;
        }

        return $dummy->next;
    }
}
