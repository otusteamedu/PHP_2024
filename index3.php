<?php

use KRudenko\Otus\ListNode;
use KRudenko\Otus\Solution;

require __DIR__ . '/vendor/autoload.php';

$list1 = new ListNode(null);
$list2 = new ListNode(0);

$solution = (new Solution())->mergeTwoLists($list1, $list2);

$arr = $solution->toArray();
$result = $arr === [0] ? 'true' : 'false';
$stringArr = '[' . implode(',', $arr) . ']';
echo <<<LOG
Input: list1 = [], list2 = [0]
Output: $stringArr
Expected: [0]
Solution: $result

LOG;
