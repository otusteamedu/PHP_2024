<?php
declare(strict_types=1);


// Definition for a singly-linked list.
class ListNode {
     public $val = 0;
     public $next = null;
     function __construct($val = 0, $next = null) {
         $this->val = $val;
         $this->next = $next;
     }
}


class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        $result = new ListNode();
        $current = $result;
        $iList1 = $iList2 = 0;

        while (
            !is_null($list1) && !is_null($list2) &&
            ($iList1 < 50 && $iList2 < 50) &&
            ($list1->val >= -100 && $list1->val <= 100) &&
            ($list2->val >= -100 && $list2->val <= 100)
        ) {
            if ($list1->val <= $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
                $iList1++;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
                $iList2++;
            }
            $current = $current->next;
        }
        if (!is_null($list1)) {
            $current->next = $list1;
            $current = $current->next;
        }
        if (!is_null($list2)) {
            $current->next = $list2;
            $current = $current->next;
        }
        return $result->next;
    }
}