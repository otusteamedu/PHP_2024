<?php

namespace TwoSortedLists;

class ListNode {
public $val = 0;
public $next = null;

function __construct($val = 0, $next = null) {
$this->val = $val;
$this->next = $next;
}
}

class Solution {
/**
* @param ListNode $list1
* @param ListNode $list2
* @return ListNode
*/
public function mergeTwoLists($list1, $list2) {
if ($list1 === null) {
return $list2;
}
if ($list2 === null) {
return $list1;
}

if ($list1->val <= $list2->val) {
$newlist = $list1;
$list1 = $list1->next;
} else {
$newlist = $list2;
$list2 = $list2->next;
}

$current = $newlist;

while ($list1 && $list2) {
if ($list1->val <= $list2->val) {
$current->next = $list1;
$list1 = $list1->next;
} else {
$current->next = $list2;
$list2 = $list2->next;
}
$current = $current->next;
}

if ($list1 !== null) {
$current->next = $list1;
} else {
$current->next = $list2;
}

return $newlist;
}
}