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
class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {
        $list = new ListNode();
        $current = $list;

        while (!empty($list1) && !empty($list2)) {
            if ($list1->val > $list2->val) {
                $current->next = new ListNode($list2->val);
                $current = $current->next;
                $list2 = $list2->next;
            } else {
                $current->next = new ListNode($list1->val);
                $current = $current->next;
                $list1 = $list1->next;
            }
        }
        if (!empty($list1)) {
            $current->next = $list1;
        } else {
            $current->next = $list2;
        }

        return $list->next;
    }

}
