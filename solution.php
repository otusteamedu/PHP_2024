<?php

namespace ValentinFilshin;

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
        if ($list1 == null) {
            return $list2;
        }
        if ($list2 == null) {
            return $list1;
        }

        $dummyHead = new ListNode(0);
        $current = $dummyHead;

        // Проходим по спискам, пока оба не закончатся
        while ($list1 !== null && $list2 !== null) {
            if ($list1->val <= $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }

        // Присоединяем оставшуюся часть непустого списка
        $current->next = $list1 !== null ? $list1 : $list2;

        return $dummyHead->next;
    }
}

/**
 * Т.к. мы проходимся в цикле while по обоим спискам, то сложность n+m, что равно просто сложности n
 * Time Complexity O(n+m) => O(n)
 * Space Complexity O(1)
 */
