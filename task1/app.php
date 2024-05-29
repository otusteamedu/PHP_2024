<?php

declare(strict_types=1);

use VictoriaBabikova\IntersectionNode\ListNode;
use VictoriaBabikova\IntersectionNode\Solution;

require_once __DIR__ . '/vendor/autoload.php';

$intersectVal = 8;

$listA = new ListNode(4);
$listA->next = new ListNode(1);
$listA->next->next = new ListNode($intersectVal);
$listA->next->next->next = new ListNode(4);
$listA->next->next->next->next = new ListNode(5);

$listB = new ListNode(5);
$listB->next = new ListNode(6);
$listB->next->next = new ListNode(1);
$listB->next->next->next = $listA->next->next;

$solution = new Solution();

var_dump($solution->getIntersectionNode($listA, $listB));
