<?php
class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

function mergeTwoLists(ListNode $node1, ListNode $node2): ListNode
{
    $firsNode = null;
    $prevNode = null;
    do {
        if ($node1 && $node2) {
            if ($node1->val < $node2->val) {
                $node = $node1;
                $node1 = $node1->next;
            } else {
                $node = $node2;
                $node2 = $node2->next;
            }
        } else {
            if ($node1) {
                $node = $node1;
                $node1 = $node1->next;
            } else {
                $node = $node2;
                $node2 = $node2->next;
            }
        }

        if ($prevNode) {
            $prevNode->next = new ListNode($node->val);
            $prevNode = $prevNode->next;
        } else {
            $prevNode = new ListNode($node->val);
        }

        $firsNode = $firsNode ?: $prevNode;
    }
    while ($node1 || $node2);

    return $firsNode;
}