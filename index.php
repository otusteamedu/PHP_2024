<?php
require __DIR__ . '/vendor/autoload.php';

use EkaterinaKonyaeva\OtusComposerApp\Application\Solution;
use EkaterinaKonyaeva\OtusComposerApp\Application\ListNode;
use EkaterinaKonyaeva\OtusComposerApp\Application\SolutionSecond;

// case 1
$node1 = new ListNode(4);
$node2 = new ListNode(1);
$node3 = new ListNode(8);
$node4 = new ListNode(4);
$node5 = new ListNode(5);
$node1->next = $node2;
$node2->next = $node3;
$node3->next = $node4;
$node4->next = $node5;
$node6 = new ListNode(5);
$node7 = new ListNode(6);
$node7->next = $node3;
$solution = new Solution();
$intersectionNode = $solution->getIntersectionNode($node1, $node7);
echo $intersectionNode->val;

// case 2
$node1 = new ListNode(1);
$node2 = new ListNode(9);
$node3 = new ListNode(1);
$node4 = new ListNode(2);
$node5 = new ListNode(4);

$node1->next = $node2;
$node2->next = $node3;
$node3->next = $node4;
$node4->next = $node5;

$node6 = new ListNode(3);
$node6->next = $node4;

$solution = new Solution();
$intersectionNode = $solution->getIntersectionNode($node1, $node6);
echo $intersectionNode->val;

// case 3
$node1 = new ListNode(2);
$node2 = new ListNode(6);
$node3 = new ListNode(4);

$node1->next = $node2;
$node2->next = $node3;

$node4 = new ListNode(1);
$node5 = new ListNode(5);
$node4->next = $node5;

$solution = new Solution();
$intersectionNode = $solution->getIntersectionNode($node1, $node4);

echo $intersectionNode;
echo '<br>';
//task 2

$res = new SolutionSecond;

echo $res->fractionToDecimal(1,2) . '<br>';
echo $res->fractionToDecimal(2,1). '<br>';
echo $res->fractionToDecimal(4,333);