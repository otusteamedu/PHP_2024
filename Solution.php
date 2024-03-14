<?php

namespace IlyaPlotnikov\HomeWork;

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
        if (empty($list1)) {
            return $list2;
        }

        if (empty($list2)) {
            return $list1;
        }

        if ($list1->val <= $list2->val) {
            $result = $list1;
            $list1 = $list1->next;
        } else {
            $result = $list2;
            $list2 = $list2->next;
        }

        $head = $result;

        while ($list1 && $list2) {
            if ($list1->val <= $list2->val) {
                $result->next = $list1;
                $list1 = $list1->next;
            } else {
                $result->next = $list2;
                $list2 = $list2->next;
            }

            $result = $result->next;
        }

        if ($list2) {
            $result->next = $list2;
        } else {
            $result->next = $list1;
        }

        return $head;
    }
}
