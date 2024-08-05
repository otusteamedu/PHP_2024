<?php
class ListNode
{
  public $val = 0;
  public $next = null;
  function __construct($val = 0, $next = null)
  {
    $this->val = $val;
    $this->next = $next;
  }
}

class Solution
{
  /**
   * @param ListNode $list1
   * @param ListNode $list2
   * @return ListNode
   */
  function mergeTwoLists($list1, $list2)
  {
    if (empty($list1))
      return $list2;
    if (empty($list2))
      return $list1;
    if ($list1->val < $list2->val) {
      $mergeList = new ListNode($list1->val);
      $list1 = $list1->next;
    } else {
      $mergeList = new ListNode($list2->val);
      $list2 = $list2->next;
    }
    $listNode = $mergeList;


    while (!is_null($list1) && !is_null($list2)) {
      if ($list1->val < $list2->val) {
        $nextValue = $list1->val;
        $list1 = $list1->next;
      } else {
        $nextValue = $list2->val;
        $list2 = $list2->next;
      }
      $listNode->next = new ListNode($nextValue);
      $listNode = $listNode->next;
    }
    return $mergeList;
  }
}


$list1 = new ListNode(1, new ListNode(2, new ListNode(4)));
$list2 = new ListNode(1, new ListNode(3, new ListNode(4)));
$solution = new Solution;
$res = $solution->mergeTwoLists($list1, $list2);
var_dump($res);
