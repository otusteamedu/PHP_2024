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
        // Создаем вспомогательный узел
        $dummy = new ListNode();
        $current = $dummy; 

        // Проходим оба списка, пока хотя бы один не станет пустым
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

        // Присоединяем оставшиеся узлы (если есть)
        if ($list1 !== null) {
            $current->next = $list1;
        } else {
            $current->next = $list2;
        }

        return $dummy->next; 
    }
}
