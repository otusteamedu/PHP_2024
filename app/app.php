<?php

declare(strict_types=1);

use App\ListNode;
use App\Solution;

require __DIR__.'/vendor/autoload.php';

$list1 = new ListNode(1,
            new ListNode(2,
                new ListNode(4))
);
$list2 = new ListNode(1,
            new ListNode(3,
                new ListNode(4))
);
$app = new Solution();
print_r($app->mergeTwoLists($list1, $list2));
