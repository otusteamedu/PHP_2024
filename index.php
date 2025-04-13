<?php

declare(strict_types=1);

/**
 * Definition for singly-linked list.
 */
class ListNode
{
    /**
     * @var int
     */
    public int $val = 0;

    /**
     * @var ListNode|null
     */
    public ?ListNode $next = null;

    /**
     * ListNode constructor.
     *
     * @param int $val
     * @param ListNode|null $next
     */
    function __construct(int $val = 0, ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

/**
 * Solution class to merge two sorted linked lists.
 */
class Solution
{
    /**
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode
     */
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ListNode
    {
        if ($list1 == null) {
            return $list2;
        }

        if ($list2 == null) {
            return $list1;
        }

        // Compare the values of the two lists and merge accordingly
        if ($list1->val < $list2->val) {
            $list1->next = $this->mergeTwoLists($list1->next, $list2);

            return $list1;
        } else {
            $list2->next = $this->mergeTwoLists($list2->next, $list1);

            return $list2;
        }
    }
}
