<?php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        if (!$headA || !$headB) {
            return null;
        }

        $aPointer = $headA;
        $bPointer = $headB;

       
        while ($aPointer !== $bPointer) {
            $aPointer = $aPointer ? $aPointer->next : $headB;
            $bPointer = $bPointer ? $bPointer->next : $headA;
        }

        return $aPointer; 
    }
}
