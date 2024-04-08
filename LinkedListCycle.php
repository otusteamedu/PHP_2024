<?php

declare(strict_types=1);

// phpcs:ignore
class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

// phpcs:ignore
class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(ListNode $head): bool
    {
        $visitedNodes = [];
        $currentNode = $head;

        while ($currentNode !== null) {
            if (in_array($currentNode, $visitedNodes, true)) {
                return true;
            }
            $visitedNodes[] = $currentNode;
            $currentNode = $currentNode->next;
        }

        return false;
    }
}
