<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alogachev\Homework\ListNode;
use App\TwoListIntersection;

// First list
$node1 = new ListNode(1);
$node2 = new ListNode(2, $node1);
$node3 = new ListNode(3, $node2);
$node4 = new ListNode(4, $node3);
$node5 = new ListNode(5, $node4);
// Second list
$node6 = new ListNode(6);
$node7 = new ListNode(7, $node6);
$node8 = new ListNode(8, $node7);
$node9 = new ListNode(9, $node8);
$node10 = new ListNode(10, $node9);
$node11 = new ListNode(11);

// Set up the common node
$node1->next = $node6;
// The next node after common
$node6->next = $node11;

$twoListIntersection = new TwoListIntersection();
echo $twoListIntersection->getIntersectionNode($node5, $node10) . PHP_EOL;
