<?php

declare(strict_types=1);

class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val)
    {
        $this->val = $val;
    }
}

class SolutionTask1
{
    /**
     * Detect if a linked list has a cycle.
     *
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle(ListNode $head): bool
    {
        if ($head->next === null) {
            return false;
        }

        $slow = $head;
        $fast = $head->next;

        while ($slow !== $fast) {
            if ($fast === null || $fast->next === null) {
                return false;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return true;
    }
}
