<?php

class ListNode {
   public $val = 0;
   public $next = null;
   function __construct($val = 0, $next = null) {
       $this->val = $val;
       $this->next = $next;
   }

  /**
   * @param ListNode $list1
   * @param ListNode $list2
   * @return ListNode
   * 
   * сложность O(n1+n2)
   * 
   */


  static function mergeTwoLists($list1, $list2): ListNode {
      $listPointer = null;

      while($list1 || $list2){

          if(!$list1 || $list1->val > $list2->val){
            $list  = new ListNode($list2->val);
            $list2 = $list2->next;  
          } 
          else{
            $list  = new ListNode($list1->val);
            $list1 = $list1->next;  
          } 
          if($listPointer) $listPointer->next = $list; 
          else $listResult = $list;
          $listPointer = $list;
      }
      if(!$listResult) $listResult = new ListNode();
      return $listResult;    
    }

  function print(){
    $list = $this;
    while($list){
      echo "->".$list->val;
      $list = $list->next;        
    }
    echo '<br>';
  }
}

$list13 = new ListNode(4);
$list12 = new ListNode(2,$list13);
$list11 = new ListNode(1,$list12);
$list11->print();

$list23 = new ListNode(4);
$list22 = new ListNode(3,$list23);
$list21 = new ListNode(1,$list22);
$list21->print();

$listMerge = ListNode::mergeTwoLists($list11, $list21);
$listMerge->print();
