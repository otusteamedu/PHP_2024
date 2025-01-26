<?php

use Den\Php2024\ListNode;
use Den\Php2024\SolutionHasCycle;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $node1 = new ListNode(3);
    $node2 = new ListNode(2);
    $node3 = new ListNode(0);
    $node4 = new ListNode(-4);

    $node1->setNext($node2)->setNext($node3)->setNext($node4)->setNext($node2);

    $listNode = $node1;

    var_dump(SolutionHasCycle::hasCycle($listNode));
    unset($listNode, $node1, $node2, $node3, $node4);

    $node1 = new ListNode(1);
    $node2 = new ListNode(2);

    $listNode = $node1->setNext($node2)->setNext($node1);
    var_dump(SolutionHasCycle::hasCycle($listNode));
    unset($listNode, $node1, $node2);

    $listNode = new ListNode(1);
    var_dump(SolutionHasCycle::hasCycle($listNode));
    unset($listNode);
} catch (Exception $exception) {
    echo 'Ошибка: ' . $exception->getMessage() . PHP_EOL;
}
