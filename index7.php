<?php

use KRudenko\Otus\ListNode;
use KRudenko\Otus\Solution;

require __DIR__ . '/vendor/autoload.php';

$list1 = new ListNode(-2, new ListNode(5));
$list2 = new ListNode(-9, new ListNode(-6, new ListNode(-3, new ListNode(-1, new ListNode(1, new ListNode(6))))));

$solution = (new Solution())->mergeTwoLists($list1, $list2);

$arr = $solution->toArray();
$result = $arr === [-9,-6,-3,-2,-1,1,5,6] ? 'true' : 'false';
$stringArr = '[' . implode(',', $arr) . ']';
echo <<<LOG
Input: list1 = [-2,5], list2 = [-9,-6,-3,-1,1,6]
Output: $stringArr
Expected: [-9,-6,-3,-2,-1,1,5,6]
Solution: $result

LOG;
