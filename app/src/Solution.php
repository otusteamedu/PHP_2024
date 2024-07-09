<?php

namespace Evgenyart\Leetcode;

class Solution
{

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {
        if ($list1 === null) {
            return $list2;
        }
            
        if ($list2 === null) {
            return $list1;
        }

        $result = new ListNode();
        $current = $result;
        while ($list1 && $list2) {
            if ($list1->val <= $list2->val) {
                $current->next = new ListNode($list1->val);
                $list1 = $list1->next;
            } else {
                $current->next = new ListNode($list2->val);
                $list2 = $list2->next;
            }
            $current = $current->next;
        }
        
        if ($list1 && !$list2) {
            $current->next = $list1;
        } elseif (!$list1 && $list2) {
            $current->next = $list2;
        }

        return $result->next;
    }
}
