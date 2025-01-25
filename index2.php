<?php

use KRudenko\Otus\ListNode;
use KRudenko\Otus\Solution;

require __DIR__ . '/vendor/autoload.php';

$list1 = new ListNode(null);
$list2 = new ListNode(null);

$solution = (new Solution())->mergeTwoLists($list1, $list2);

$arr = $solution->toArray();
$result = $arr === [] ? 'true' : 'false';
$stringArr = '[' . implode(',', $arr) . ']';
echo <<<LOG
Input: list1 = [], list2 = []
Output: $stringArr
Expected: []
Solution: $result

LOG;
