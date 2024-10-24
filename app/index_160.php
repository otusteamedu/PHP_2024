<?php

declare(strict_types=1);

use Evgenyart\Hw19\ListNode;
use Evgenyart\Hw19\SolutionIntersectionofTwoLinkedLists;

require_once(__DIR__ . '/vendor/autoload.php');

$solution = new SolutionIntersectionofTwoLinkedLists();

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

$result = $solution->getIntersectionNode($listA, $listB);

var_dump($result);

print_r(PHP_EOL . "--------------------" . PHP_EOL);

$$intersectVal = 2;
$listA2 = new ListNode(1);
$listA2->next = new ListNode(9);
$listA2->next->next = new ListNode(1);
$listA2->next->next->next = new ListNode($intersectVal);
$listA2->next->next->next->next = new ListNode(4);

$listB2 = new ListNode(3);
$listB2->next = $listA2->next->next->next;

$result2 = $solution->getIntersectionNode($listA2, $listB2);

var_dump($result2);

print_r(PHP_EOL . "--------------------" . PHP_EOL);

$listA3 = new ListNode(2);
$listA3->next = new ListNode(6);
$listA3->next->next = new ListNode(4);

$listB3 = new ListNode(1);
$listB3->next = new ListNode(5);

$result3 = $solution->getIntersectionNode($listA3, $listB3);

var_dump($result3);
