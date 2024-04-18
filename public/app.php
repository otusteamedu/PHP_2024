<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Alogachev\Homework\CycledList;
use Alogachev\Homework\LetterCombination;
use Alogachev\Homework\ListNode;

$node1 = new ListNode(1);
$node2 = new ListNode(2, $node1);
$node3 = new ListNode(3, $node2);
$node4 = new ListNode(4, $node3);
$node5 = new ListNode(5, $node4);
$node1->next = $node5;

$isCycled = new CycledList();
echo $isCycled->hasCycle($node1) . PHP_EOL;

$digits = '23';

$letterCombinator = new LetterCombination();
$letterCombination = $letterCombinator->letterCombinations($digits);
var_dump($letterCombination);
