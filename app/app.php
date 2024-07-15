<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw29\ListNode;
use Lrazumov\Hw29\IntersectionTwoLInkedList;
use Lrazumov\Hw29\FractionRecurringDecimal;

try {

    $intersection_part = new ListNode(
        8,
        new ListNode(
            4,
            new ListNode(5)
        )
    );

    // [4,1,8,4,5], skipA = 2
    $list1 = new ListNode(
        4,
        new ListNode(
            1,
            $intersection_part
        )
    );

    // [5,6,1,8,4,5], skipB = 3
    $list2 = new ListNode(
        5,
        new ListNode(
            6,
            new ListNode(
                1,
                $intersection_part
            )
        )
    );

    $solution = (new IntersectionTwoLInkedList())
        ->solution($list1, $list2);

    if ($solution) {
        echo sprintf('Intersected at "%s"', $solution->val);
    } else {
        echo 'No intersection';
    }

    echo PHP_EOL;

    $solution = (new FractionRecurringDecimal())
        ->solution(1, 17);
    echo $solution;

    echo PHP_EOL;

} catch (\Exception $e) {
    echo $e->getMessage();
}
