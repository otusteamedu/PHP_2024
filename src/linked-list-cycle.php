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
    function hasCycle($head): bool {
        $fastPointer = $slowPointer = $head;
        while (($fastPointer->next !== null && $fastPointer->next->next) && $slowPointer->next !== null) {
            $slowPointer = $slowPointer->next;
            $fastPointer = $fastPointer->next->next;
            if ($slowPointer === $fastPointer) {
                return true;
            }
        }
        return false;
    }
}