<?php

declare(strict_types=1);

namespace Ashilyaev\Hw7;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2): ListNode
    {
        if ($list1 === null) {
            return $list2;
        } elseif ($list2 === null) {
            return $list1;
        }

        $resultList = null;
        if ($list1->val < $list2->val) {
            $resultList = $list1;
            $resultList->next = $this->mergeTwoLists($list1->next, $list2);
        } else {
            $resultList = $list2;
            $resultList->next = $this->mergeTwoLists($list1, $list2->next);
        }
        return $resultList;
    }
}
