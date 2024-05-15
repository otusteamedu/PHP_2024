<?php

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head)
    {
        $current = $next = $head;
        while ($next && $next->next) {
            $current = $current->next;
            $next = $next->next->next;
            if ($current === $next) {
                return true;
            }
        }
        return false;
    }
}
