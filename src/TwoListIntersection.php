<?php

declare(strict_types=1);

namespace App;

use Alogachev\Homework\ListNode;

class TwoListIntersection
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB)
    {
        if ($headA === null || $headB === null) {
            return null;
        }

        $pointerA = $headA;
        $pointerB = $headB;

        // Поменяем местами указатели, когда они достигнут конца списков
        while ($pointerA !== $pointerB) {
            $pointerA = $pointerA === null ? $headB : $pointerA->next;
            $pointerB = $pointerB === null ? $headA : $pointerB->next;
        }

        return $pointerA;
    }
}
