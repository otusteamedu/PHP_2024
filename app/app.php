<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw19\ListNode;
use Lrazumov\Hw19\Solution;

try {
    // head = [3,2,0,-4], pos = 1
    $list = new ListNode(
        3,
        new ListNode(
            2,
            new ListNode(
                0,
                new ListNode(-4)
            )
        )
    );
    $node = $list->next;
    $list->next->next->next->next = $node;
    $solution = (new Solution())
        ->hasCycle($list);
    var_dump($solution);

    // head = [1], pos = -1
    $list = new ListNode(
        1
    );
    $solution = (new Solution())
        ->hasCycle($list);
    var_dump($solution);
} catch (\Exception $e) {
    echo $e->getMessage();
}
