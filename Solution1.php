<?php

namespace Otus;

/**
* Definition for a singly-linked list.
* class ListNode {
*     public $val = 0;
*     public $next = null;
*     function __construct($val) { $this->val = $val; }
* }
*/

class Solution1
{
    /**
    * @param ListNode $head
    * @return Boolean
    */
    public function hasCycle($head): bool
    {
        if ($head === null || $head->next === null) {
            return false;
        }

        $hash = [];
        $current = $head;
        while ($current !== null) {
            $objHash = spl_object_id($current);
            $hash[$objHash] += 1;
            if ($hash[$objHash] > 1) {
                return true;
            }
            $current = $current->next;
        }

        return false;
    }
}
