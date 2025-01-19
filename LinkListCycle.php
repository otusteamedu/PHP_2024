<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class ListNode {
     public $val = 0;
     public $next = null;
     function __construct($val) { $this->val = $val; }
}

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
       $hash = [];
       $next = $head;
       while( $next !== null){
            if(in_array($next, $hash, true)) return true;  
            $hash[] = $next;
            $next = $next->next;
       } 
       return false;  
    }
}

$ListNode1 = new ListNode(3); 
$ListNode2 = new ListNode(2);
$ListNode3 = new ListNode(0);
$ListNode4 = new ListNode(-4);
$ListNode1->next = $ListNode2;
$ListNode2->next = $ListNode3;
$ListNode3->next = $ListNode4;
$ListNode4->next = $ListNode2;

$solve = new Solution();
print_r($solve->hasCycle($ListNode1));