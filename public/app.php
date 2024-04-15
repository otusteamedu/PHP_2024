<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alogachev\Homework\ListMerge;
use Alogachev\Homework\ListNode;

$list1 = new ListNode(1, new ListNode(2, new ListNode(4)));
$list2 = new ListNode(1, new ListNode(3, new ListNode(4)));


$mergeList = new ListMerge();
$mergedList = $mergeList->mergeTwoLists($list1, $list2);

while (!is_null($mergedList->next)) {
    echo $mergedList->val . PHP_EOL;
    $mergedList = $mergedList->next;
}

$node1 = new ListNode(1);
$node2 = new ListNode(2, $node1);
$node3 = new ListNode(3, $node2);
$node4 = new ListNode(4, $node3);
$node5 = new ListNode(5, $node4);
$node1->next = $node5;
dump($node5);


