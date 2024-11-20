<?php

use AlexAgapitov\OtusComposerProject\ListNode;
use AlexAgapitov\OtusComposerProject\Solution;

require __DIR__.'/vendor/autoload.php';

$list1 = new ListNode(4,
    (new ListNode(1, (new ListNode(8, (new ListNode(4, (new ListNode(5)))))))));
$list2 = new ListNode(5, (new ListNode(6,
    (new ListNode(1, (new ListNode(8, (new ListNode(4, (new ListNode(5)))))))))));

$res = Solution::getIntersectionNode($list1, $list2);
var_dump($res);

$list1 = new ListNode(2, (new ListNode(6, (new ListNode(4)))));
$list2 = new ListNode(1, (new ListNode(5)));

$res = Solution::getIntersectionNode($list1, $list2);
var_dump($res);

$list1 = new ListNode(1, (new ListNode(9, (new ListNode(1,
    (new ListNode(2, (new ListNode(4)))))))));
$list2 = new ListNode(3,
    (new ListNode(2, (new ListNode(4)))));

$res = Solution::getIntersectionNode($list1, $list2);
var_dump($res);


$res = Solution::fractionToDecimal(1,2);
var_dump($res);
$res = Solution::fractionToDecimal(2,1);
var_dump($res);
$res = Solution::fractionToDecimal(4,333);
var_dump($res);