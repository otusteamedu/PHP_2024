<?php

namespace EkaterinaKonyaeva\OtusComposerApp\Application;

use \EkaterinaKonyaeva\OtusComposerApp\Application\ListNode;

class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode|null
     */
    function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        if ($headA == null || $headB == null) {
            return null;
        }

        $ptrA = $headA;
        $ptrB = $headB;

        while ($ptrA !== $ptrB) {
            $ptrA = $ptrA == null ? $headB : $ptrA->next;
            $ptrB = $ptrB == null ? $headA : $ptrB->next;
        }

        return $ptrA;
    }
}