<?php
// ./app/linkedlist.php

class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

function hasCycle($head) {
    if ($head === null || $head->next === null) {
        return false;
    }

    $slow = $head;
    $fast = $head;

    while ($fast !== null && $fast->next !== null) {
        $slow = $slow->next;         // Move slow pointer by 1 step
        $fast = $fast->next->next;  // Move fast pointer by 2 steps

        if ($slow === $fast) {
            return true;  // Cycle detected
        }
    }

    return false;  // No cycle detected
}