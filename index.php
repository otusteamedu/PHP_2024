<?php
require __DIR__ . '/vendor/autoload.php';

use EkaterinaKonyaeva\OtusComposerApp\Application\Solution;
use EkaterinaKonyaeva\OtusComposerApp\Application\ListNode;

$list1 = null;
$list2 = null;
$solution = new Solution();
$result = $solution->mergeTwoLists($list1, $list2);
if($result == NULL){
    echo '[],[] : NULL <br>';
}


$list1 = new ListNode(1, new ListNode(2, new ListNode(4)));
$list2 = new ListNode(1, new ListNode(3, new ListNode(4)));
$solution = new Solution();
$result = $solution->mergeTwoLists($list1, $list2);

echo '[1,2,4], [1,3,4] : ';
echo $result->val;
echo $result->next->val;
echo $result->next->next->val;
echo $result->next->next->next->val;
echo $result->next->next->next->next->val;
echo $result->next->next->next->next->next->val .'<br>';

echo '[], [0] :';
$list1 = null;
$list2 = new ListNode();
$solution = new Solution();
$result = $solution->mergeTwoLists($list1, $list2);

echo $result->val;