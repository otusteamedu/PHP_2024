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
class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        $rawResul = null;
        while (1) {
            if ($list1 && !$list2 || ((!is_null($list1) && !is_null($list1)) && $list1->val <= $list2->val)) {
                $rawResul = new ListNode($list1->val, $rawResul);
                $list1 = $list1->next;
            } elseif (!$list1 && $list2 || ((!is_null($list1) && !is_null($list1)) && $list1->val > $list2->val)) {
                $rawResul = new ListNode($list2->val, $rawResul);
                $list2 = $list2->next;
            } else {
                break;
            }
        }

        while (1) {
            $finalResul = new ListNode($rawResul->val, $finalResul);
            if ($rawResul->next) {
                $rawResul = $rawResul->next;
            } else {
                break;
            }
        }

        return $finalResul;
    }
}