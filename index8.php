<?php

use KRudenko\Otus\ListNode;
use KRudenko\Otus\Solution;

require __DIR__ . '/vendor/autoload.php';

$list1 = new ListNode(-4, new ListNode(-2, new ListNode(0, new ListNode(1, new ListNode(4)))));
$list2 = new ListNode(-9, new ListNode(-8, new ListNode(-6, new ListNode(-6, new ListNode(-5, new ListNode(-1, new ListNode(1, new ListNode(4, new ListNode(9)))))))));

$solution = (new Solution())->mergeTwoLists($list1, $list2);

$arr = $solution->toArray();
$result = $arr === [-9,-8,-6,-6,-5,-4,-2,-1,0,1,1,4,4,9] ? 'true' : 'false';
$stringArr = '[' . implode(',', $arr) . ']';
echo <<<LOG
Input: list1 = [-4,-2,0,1,4], list2 = [-9,-8,-6,-6,-5,-1,1,4,9]
Output: $stringArr
Expected: [-9,-8,-6,-6,-5,-4,-2,-1,0,1,1,4,4,9]
Solution: $result

LOG;
