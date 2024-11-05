<?php

declare(strict_types=1);

class Solution
{
    /**
     * This is a comment for PSR-linter :-)
     * 
     * @param ListNode|null $list1 The first argument
     * @param ListNode|null $list2 The second argument
     * 
     * @return ListNode|null
     */
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ListNode|null
    {
        return match (true) {
            $list1 === null && $list2 === null => null,
            $list1 !== null && $list2 === null => $list1,
            $list1 === null && $list2 !== null => $list2,

            $list1->val <= $list2->val => new ListNode(
                $list1->val, $this->mergeTwoLists($list1->next, $list2)
            ),

            $list1->val > $list2->val => new ListNode(
                $list2->val, $this->mergeTwoLists($list2->next, $list1)
            )
        };
    }
}
