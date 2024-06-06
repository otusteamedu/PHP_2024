<?php

declare(strict_types=1);

class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val) { $this->val = $val; }
}

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        $map = [];
        $cur = $head;
        while ($cur) {
            $obj_id = spl_object_id($cur);
            if (isset($map[$obj_id])) {
                return true;
            }
            $map[$obj_id] = true;
            $cur = $cur->next;
        }

        return false;
    }
}