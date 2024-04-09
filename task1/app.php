<?php

declare(strict_types=1);

use App\ListNode;
use App\Solution;

require __DIR__ . '/vendor/autoload.php';

$pos = 1;
$list = new ListNode(3, new ListNode(2, new ListNode(0, new ListNode(-4, $pos))));
$app = new Solution();
print_r($app->hasCycle($list));
