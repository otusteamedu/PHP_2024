<?php

use AlexAgapitov\OtusComposerProject\ListNode;
use AlexAgapitov\OtusComposerProject\Solution;

require __DIR__.'/vendor/autoload.php';

$list1 = new ListNode(3);
$list2 = new ListNode(2);
$list3 = new ListNode(0);
$list4 = new ListNode(-4);
$list4->setNext($list2);
$list3->setNext($list4);
$list2->setNext($list3);
$list1->setNext($list2);

$res = Solution::hasCycle($list1);

var_dump($res);

$list1 = new ListNode(1);
$list2 = new ListNode(2);
$list2->setNext($list1);
$list1->setNext($list2);

$res = Solution::hasCycle($list1);

var_dump($res);

$list1 = new ListNode(1);

$res = Solution::hasCycle($list1);

var_dump($res);

$numbers = "234";
$res = Solution::letterCombinations($numbers);

var_dump($res);