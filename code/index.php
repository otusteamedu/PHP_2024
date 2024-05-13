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
    public function mergeTwoLists($list1, $list2): ListNode
    {
        $array = [];

        $isEmptyLists = $list1?->val === null && $list2?->val === null;

        if ($isEmptyLists) {
            return new ListNode(null);
        }

        $isHasNumbers = true;

        while ($isHasNumbers) {
            if ($list1?->val !== null && ($list1->val <= $list2->val) || $list2->val === null) {
                $array[] = $list1->val;
                $list1 = $list1?->next;
            } elseif ($list2?->val !== null) {
                $array[] = $list2->val;
                $list2 = $list2?->next;
            }

            if ($list1?->val === null && $list2?->val === null) {
                $isHasNumbers = false;
            }
        }

        for ($i = count($array); $i--; $i >= 0) {
            if ($i === count($array)) {
                $next = null;
            } else {
                $next = $listNode;
            }
            $listNode = new ListNode($array[$i], $next);
        }

        return $listNode;
    }
}
