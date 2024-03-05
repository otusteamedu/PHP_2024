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
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $val1 = $list1?->val ?? PHP_INT_MAX;
        $val2 = $list2?->val ?? PHP_INT_MAX;

        return match (true) {
            $list1 === null && $list2 === null => null,
            $val1 === $val2 => new ListNode($val1, new ListNode($val2, $this->mergeTwoLists($list1?->next, $list2?->next))),
            $val1 < $val2 => new ListNode($val1, $this->mergeTwoLists($list1->next, $list2)),
            $val1 > $val2 => new ListNode($val2, $this->mergeTwoLists($list2->next, $list1)),
        };
    }
}
