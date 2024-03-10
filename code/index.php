<?php

use AlexanderPogorelov\Algorithm\ListNode;
use AlexanderPogorelov\Algorithm\Solution;

require __DIR__ . '/vendor/autoload.php';

$list1 = ListNode::createFromArray([ 1, 2, 4 ]);
$list2 = ListNode::createFromArray([ 1, 3, 4]);

var_dump((new Solution())->mergeTwoLists($list1, $list2));
