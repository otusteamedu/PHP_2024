<?php

declare(strict_types=1);

namespace App;

class LinkedList
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(ListNode $head): bool
    {
        $lNode = $head;
        $rNode = $head;

        while ($rNode !== null && $rNode->next !== null) {
            $lNode = $lNode->next;
            $rNode = $rNode->next->next;

            if ($rNode === null) {
                return false;
            } elseif ($lNode === $rNode) {
                return true;
            }
        }

        return false;
    }
}
