<?php

declare(strict_types=1);

namespace Lrazumov\Hw29;

use Lrazumov\Hw29\ListNode;

class IntersectionTwoLInkedList
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function solution(
      ListNode $headA,
      ListNode $headB
    ): ?ListNode
    {
        $index = [];
        while($headA) {
            $index[$headA->val][] = $headA;
            $headA = $headA->next;
        }
        while($headB) {
            if (isset($index[$headB->val])) {
                foreach($index[$headB->val] as $node) {
                    if ($node === $headB) {
                        return $headB;
                    }
                }
            }
            $headB = $headB->next;
        }
        return null;
    }
}
