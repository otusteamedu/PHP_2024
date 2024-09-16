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
        if (empty($list1)){
            return $list2;
        }

        if (empty($list2)){
            return $list1;
        }

        $result = new ListNode();
        $current = $result;

        while($list1 || $list2){
            if ($this->isListSmaller($list1, $list2)){
                $current->next = $list1;
                $list1 = $list1->next;
            }else{
                $current->next = $list2;
                $list2 = $list2->next;
            }

            $current = $current->next;
        }

        return $result->next;
    }

    function isListSmaller($list1, $list2): bool
    {
        if ($list1 === null){
            return false;
        }

        if ($list2 === null){
            return true;
        }

        return $list1->val <= $list2->val;
    }
}
