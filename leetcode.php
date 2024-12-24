<?php

class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution {
    function mergeTwoLists($list1, $list2) {
        $dummy = new ListNode();
        $current = $dummy;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val <= $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }

        // Присоединяем оставшиеся узлы, если есть
        if ($list1 !== null) {
            $current->next = $list1;
        } else {
            $current->next = $list2;
        }

        return $dummy->next;
    }
}

function createLinkedList($array) {
    $head = null;
    $current = null;
    foreach ($array as $value) {
        if ($head === null) {
            $head = new ListNode($value);
            $current = $head;
        } else {
            $current->next = new ListNode($value);
            $current = $current->next;
        }
    }
    return $head;
}

function printLinkedList($list) {
    while ($list !== null) {
        echo $list->val . " -> ";
        $list = $list->next;
    }
    echo "null\n";
}


$list1 = createLinkedList([1, 2, 4]);
$list2 = createLinkedList([1, 3, 4]);

$solution = new Solution();
$mergedList = $solution->mergeTwoLists($list1, $list2);

printLinkedList($mergedList); // 1 -> 1 -> 2 -> 3 -> 4 -> 4 -> null