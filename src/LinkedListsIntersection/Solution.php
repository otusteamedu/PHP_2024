<?php

declare(strict_types=1);

namespace AlexanderGladkov\LinkedListIntersection;

class Solution
{
    public function getIntersectionNode(?ListNode $headA, ?ListNode $headB): ?ListNode
    {
        if ($headA === null || $headB === null) {
            return null;
        }

        $a = $headA;
        $b = $headB;

        $lengthA = 1;
        while ($a->next !== null) {
            $lengthA++;
            $a = $a->next;

        }

        $lengthB = 1;
        while ($b->next !== null) {
            $lengthB++;
            $b = $b->next;
        }

        if ($a !== $b) {
            return null;
        }

        $a = $headA;
        $b = $headB;
        if ($lengthA >= $lengthB) {
            $difference = $lengthA - $lengthB;
            while ($difference > 0) {
                $a = $a->next;
                $difference--;
            }
        } else {
            $difference = $lengthB - $lengthA;
            while ($difference > 0) {
                $b = $b->next;
                $difference--;
            }
        }

        while($a !== $b) {
            $a = $a->next;
            $b = $b->next;
        }

        return $a;
    }
}
