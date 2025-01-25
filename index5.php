<?php

use KRudenko\Otus\ListNode;
use KRudenko\Otus\Solution;

require __DIR__ . '/vendor/autoload.php';

$list1 = new ListNode(5);
$list2 = new ListNode(1, new ListNode(2, new ListNode(4)));

$solution = (new Solution())->mergeTwoLists($list1, $list2);

$arr = $solution->toArray();
$result = $arr === [1,2,4,5] ? 'true' : 'false';
$stringArr = '[' . implode(',', $arr) . ']';
echo <<<LOG
Input: list1 = [5], list2 = [1,2,4]
Output: $stringArr
Expected: [1,2,4,5]
Solution: $result

LOG;
