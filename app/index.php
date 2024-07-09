<?php

use Evgenyart\Leetcode\ListNode;
use Evgenyart\Leetcode\Solution;

require_once(__DIR__ . '/vendor/autoload.php');

$list1 = new ListNode(1, new ListNode(2, new ListNode(4)));
$list2 = new ListNode(1, new ListNode(3, new ListNode(4)));

$solution = new Solution();

$res = $solution->mergeTwoLists($list1, $list2);

print_r($res);
