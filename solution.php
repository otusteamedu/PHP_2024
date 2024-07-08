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
    function mergeTwoLists($list1, $list2)
    {
        if ($list1 == null) {
            return $list2;
        }

        if ($list2 == null) {
            return $list1;
        }

        $dh = $c = $list2;

        if ($list1->val < $c->val) {
            $tmp = $list1;
            $list1 = $list1->next;
            $tmp->next = $c;
            $dh = $c = $tmp;
        }

        while ($list1 != null) {
            if ($c->next == null) {
                $c->next = $list1;
                break;
            }

            if ($c->next->val < $list1->val) {
                $c = $c->next;
            } else {
                $tmp = $list1;
                $list1 = $list1->next;
                $tmp->next = $c->next;
                $c->next = $tmp;
                $c = $tmp;
            }

        }

        return $dh;
    }
}
