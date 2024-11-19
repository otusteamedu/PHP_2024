<?php

use Ali\ListNode;
use Ali\Solution;

require_once __DIR__ . '/vendor/autoload.php';

$list1 = new ListNode(1, new ListNode(2, new ListNode(4)));
$list2 = new ListNode(1, new ListNode(3, new ListNode(4)));

$res = Solution::mergeTwoLists($list1, $list2);
var_dump($res);

$list1 = null;
$list2 = null;

$res = Solution::mergeTwoLists($list1, $list2);
var_dump($res);

$list1 = null;
$list2 = new ListNode(0);

$res = Solution::mergeTwoLists($list1, $list2);
var_dump($res);