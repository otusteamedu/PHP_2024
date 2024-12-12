<?php

require ('ListNode.php');
require ('Solution.php');

$node1_9 = new ListNode(9);
$node1_6 = new ListNode(6, $node1_9);
$node1_2 = new ListNode(2, $node1_6);
$node1_1 = new ListNode(1, $node1_2);

$node2_10 = new ListNode(10);
$node2_9 = new ListNode(9, $node2_10);
$node2_8 = new ListNode(8, $node2_9);
$node2_7 = new ListNode(7, $node2_8);
$node2_6 = new ListNode(6, $node2_7);
$node2_5 = new ListNode(5, $node2_6);
$node2_3 = new ListNode(3, $node2_5);
$node2_1 = new ListNode(1, $node2_3);

$node = Solution::mergeTwoLists($node1_1, $node2_1);
print_r($node);