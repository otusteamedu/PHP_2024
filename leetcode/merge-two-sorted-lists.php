<?php
/**
 * Ссылка на решение - https://leetcode.com/problems/merge-two-sorted-lists/submissions/1201789332/
 * Временная сложность:
 * Алгоритм проходит по всем узлам обоих списков, поэтому сложность = O(list1_n + list2_n) = O(n);
 *
 * Пространственная сложность:
 * Узлы копируются в новый список ($result), поэтому дополнительная память равна = O(n);
 *
*/
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
        if (!$list2) {
            return $list1;
        }

        if (!$list1) {
            return $list2;
        }

        $pointerA = $list1;
        $pointerB = $list2;

        if ($pointerB->val > $pointerA->val) {
            $head = $pointerA;
            $pointerA = $pointerA->next;

        } else {
            $head = $pointerB;
            $pointerB = $pointerB->next;
        }
        $current = $head;

        while ($pointerA && $pointerB) {
            if ($pointerA->val >= $pointerB->val) {
                $current->next = $pointerB;
                $pointerB = $pointerB->next;
            } else {
                $current->next = $pointerA;
                $pointerA = $pointerA->next;
            }
            $current = $current->next;
        }

        if (!$pointerA) {
            $current->next = $pointerA;
        }

        if (!$pointerB) {
            $current->next = $pointerB;
        }
        return $head;
    }
}