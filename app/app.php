<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw10\Solution;
use Lrazumov\Hw10\ListNode;

try {
    // [1,2,4]
    $list1 = new ListNode(
        1,
        new ListNode(
            2,
            new ListNode(4)
        )
    );

    // [1,3,4]
    $list2 = new ListNode(
        1,
        new ListNode(
            3,
            new ListNode(4)
        )
    );

    $solution = (new Solution())
        ->mergeTwoLists($list1, $list2);

    var_dump($solution);

} catch (\Exception $e) {
    echo $e->getMessage();
}