<?php

namespace VKomar;

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
        $list = $head = new ListNode();

        while ($list1 || $list2) {
            if (!$list1 || ($list2 && $list1->val > $list2->val)) {
                $list->next = $list2;
                $list2 = $list2->next;
            } else {
                $list->next = $list1;
                $list1 = $list1->next;
            }
            $list = $list->next;
        }

        return $head->next;
    }
}
