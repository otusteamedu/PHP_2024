<?php

namespace Komarov\Hw8\App;

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
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     *
     * @return ListNode|null
     */
    public static function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $dummy = new ListNode();
        $current = $dummy;

        while (isset($list1, $list2)) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }

            $current = $current->next;
        }

        $current->next = $list1 ?? $list2;

        return $dummy->next;
    }
}
