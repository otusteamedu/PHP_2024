<?php
//phpcs:ignoreFile

declare(strict_types=1);

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class Solution
{
    /**
     * Сложность O(n) - Алгоритмическая сложность прямо пропорциональна количеству элементов в списках
     *
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode($headA, $headB)
    {
        $a = $headA;
        $b = $headB;
        while ($a !== $b) {
            $a = $a === null ? $headB : $a->next;
            $b = $b === null ? $headA : $b->next;
        }

        return $a;
    }
}
