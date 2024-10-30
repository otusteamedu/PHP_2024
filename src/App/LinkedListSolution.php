<?php

namespace VSukhov\Hw13\App;

class LinkedListSolution
{
    /**
     * @param NodeList $head
     * @return Boolean
     */
    public function hasCycle(NodeList $head): bool
    {
        $slow = $head;
        $fast = $head;

        while ($fast !== null && $fast->next !== null) {
            $slow = $slow->next;
            $fast = $fast->next->next;

            if ($slow === $fast) {
                return true;
            }
        }

        return false;
    }
}
