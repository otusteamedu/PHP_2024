<?php

declare(strict_types=1);

namespace App;

class IntersectionNodeSolution
{
    public static function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $hashMap = [];

        while ($headA !== null) {
            $hashMap[spl_object_hash($headA)] = true;
            $headA = $headA->next;
        }

        while ($headB !== null) {
            if (isset($hashMap[spl_object_hash($headB)])) {
                return $headB;
            }

            $headB = $headB->next;
        }

        return null;
    }
}
