<?php

namespace Evgenyart\Hw14;

class SolutionLinkedListCycle
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head)
    {

        if ($head == null || $head->next == null) {
            return false;
        }

        $hash = [];
        $node = $head;

        while ($node && isset($node->next)) {
            if ($node->next == null) {
                return false;
            }

            if (in_array($node, $hash, true)) {
                return true;
            }

            $hash[] = $node;
            $node = $node->next;
        }
        return false;
    }
}
