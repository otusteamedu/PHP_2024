<?php

declare(strict_types=1);

namespace Otus\Hw19;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class IntersectionOfTwoLinkedLists
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode|null
     */
    public function getIntersectionNode($headA, $headB): ?ListNode
    {
        if ($headA === null || $headB === null) {
            return null;
        }

        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = $pointerA ? $pointerA->next : $headB;
            $pointerB = $pointerB ? $pointerB->next : $headA;
        }

        return $pointerA;
    }
}

/**
 * Time complexity: O(n) - максимум пройдемся по всем элементам двух списков один раз
 */
