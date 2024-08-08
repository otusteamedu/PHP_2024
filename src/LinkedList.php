<?php

declare(strict_types=1);

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class LinkedList
{
    //Time complexity = O(N)
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head)
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
