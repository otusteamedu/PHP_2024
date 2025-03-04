<?php

namespace App;

class TaskNode
{
    private $nodes;

    public function __construct()
    {
        $listNode3 = new ListNode(3);
        $listNode2 = new ListNode(2);
        $listNode0 = new ListNode(0);
        $listNode4 = new ListNode(4);

        $listNode3->next = $listNode2;
        $listNode2->next = $listNode0;
        $listNode0->next = $listNode4;
        $listNode4->next = $listNode2;

        $this->nodes = [
            $listNode3,
            $listNode2,
            $listNode0,
            $listNode4,
        ];
    }


    public function getHead()
    {
        return $this->nodes[0];
    }

    /**
     * @param ListNode $head
     * @return Boolean
     */
    public static function hasCycle($head)
    {
        $nextNode = $head->next;
        $passedNodes = [];

        while (!is_null($nextNode)) {
            if (in_array($nextNode, $passedNodes, true)) {
                return true;
            }

            $passedNodes[] = $nextNode;
            $nextNode = $nextNode->next;
        }

        return false;
    }
}