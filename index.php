<?php

declare(strict_types=1);

require 'ListNode.php';
require 'Solution.php';

use App\ListNode;
use App\Solution;

$solution = new Solution();

$listNode1 = new ListNode(
    1,
    new ListNode(
        2,
        new ListNode(
            4,
            null
        )
    )
);

$listNode2 = new ListNode(
    1,
    new ListNode(
        3,
        new ListNode(
            4,
            null
        )
    )
);

$result = $solution->mergeTwoLists($listNode1, $listNode2);

var_dump($result);
