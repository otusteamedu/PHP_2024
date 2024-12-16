<?php
require_once 'Solution.php';
require_once 'ListNode.php';

$list1 = new ListNode(1, new ListNode(1, new ListNode(2, new ListNode(4, new ListNode(5, new ListNode(6))))));
//$list1 = null;
$list2 = new ListNode(0, new ListNode(3, new ListNode(4, new ListNode(5, null))));
//$list2 = null;

$solution = new Solution();
$res = $solution->mergeTwoLists($list1, $list2);

echo 'solution:' . ($solution->showList($res)) . PHP_EOL;
