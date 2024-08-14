<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

namespace Task1;
 
class Solution {
   /**
    * @param ListNode $head
    * @return Boolean
    */
   public function hasCycle($head) {
      $hash = [];
      $p = $head;
      
      while ($p !== null) {
         if (in_array($p, $hash, true)) {
         return true;
         }
         $hash[] = $p;
         $p = $p->next;
      }

      return false; 
   }
}
