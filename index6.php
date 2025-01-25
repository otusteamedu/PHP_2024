<?php

use KRudenko\Otus\ListNode;
use KRudenko\Otus\Solution;

require __DIR__ . '/vendor/autoload.php';

$list1 = new ListNode(-10, new ListNode(-6, new ListNode(-6, new ListNode(-6, new ListNode(-3, new ListNode(5))))));
$list2 = new ListNode(null);

$solution = (new Solution())->mergeTwoLists($list1, $list2);

$arr = $solution->toArray();
$result = $arr === [-10,-6,-6,-6,-3,5] ? 'true' : 'false';
$stringArr = '[' . implode(',', $arr) . ']';
echo <<<LOG
Input: list1 = [-10,-6,-6,-6,-3,5], list2 = []
Output: $stringArr
Expected: [-10,-6,-6,-6,-3,5]
Solution: $result

LOG;
